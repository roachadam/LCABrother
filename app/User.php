<?php

namespace App;

use App\Role;
use App\ServiceLog;
use App\InvolvementLog;
use App\Academics;
use App\Event;
use App\Invite;
use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Commons\NotificationFunctions;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'organization_verified', 'organization_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($User) {
            NotificationFunctions::alert('success', 'Updated your details!');
            return back();
        });
    }

    //Static helper functions
    public static function findByName($name, $organizationId = null): ?User
    {
        if (isset($organizationId)) {
            return self::where([
                'organization_id' => $organizationId,
                'name' => $name,
            ])->first();
        } else {
            return self::where('name', $name)->first();
        }
    }

    public static function findById($id, $organizationId = null): ?User
    {
        if (isset($organizationId)) {
            return self::where([
                'organization_id' => $organizationId,
                'id' => $id,
            ])->first();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function findAll($organizationId = null): ?Collection
    {
        if (isset($organizationId)) {
            return self::where([
                'organization_id' => $organizationId
            ])->get();
        } else {
            return self::all();
        }
    }

    public function setBasicUser()
    {
        $role = $this->organization->roles[1];
        $this->setRole($role);
    }

    public function setAdmin()
    {
        $role = $this->organization->roles[0];
        $this->setRole($role);
    }

    public function setRole($role)
    {
        $this->role()->associate($role)->save();
    }

    public function role()
    {
        return $this->belongsTo(Role::Class);
    }

    public function join($org)
    {
        $this->organization()->associate($org)->save();
    }

    public function setVerification($verified)
    {
        if ($verified) {
            $attributes = ['organization_verified' => $verified];
        } else {
            $attributes = [
                'organization_verified' => $verified,
                'organization_id' => null
            ];
        }
        $this->update($attributes);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }

    public function isVerified()
    {
        return $this->organization_verified === 1;
    }

    public function emailVerified()
    {
        return $this->email_verified_at !== null;
    }

    // Service Logs
    public function serviceLogs()
    {
        return $this->hasMany(ServiceLog::Class);
    }

    public function getMoneyDonated()
    {
        $logs = $this->getActiveServiceLogs();
        $cash = 0;
        foreach ($logs as $log) {
            $cash += $log->money_donated;
        }
        return $cash;
    }

    public function getServiceHours()
    {
        $logs = $this->getActiveServiceLogs();
        $hours = 0;
        foreach ($logs as $log) {
            $hours += $log->hours_served;
        }
        return $hours;
    }

    public function getActiveServiceLogs()
    {
        $activeSemester = $this->organization->getActiveSemester();
        $activeServiceLogs = $this->serviceLogs()->where('created_at', '>', $activeSemester->start_date)->get();
        return $activeServiceLogs;
    }

    // Involvement Logs
    public function InvolvementLogs()
    {
        return $this->hasMany(InvolvementLog::Class);
    }

    public function addInvolvementLog($involvement, $date_of_event)
    {
        return $this->InvolvementLogs()->create([
            'organization_id' => $this->organization->id,
            'involvement_id' => $involvement['id'],
            'user_id' => $this->id,
            'date_of_event' => $date_of_event
        ]);
    }

    public function getInvolvementPoints()
    {
        $points = 0;
        foreach ($this->getActiveInvolvementLogs() as $log) {
            $points += $log->involvement->points;
        }
        return $points;
    }

    public function getActiveInvolvementLogs()
    {
        $activeSemester = $this->organization->getActiveSemester();
        $activeInvolvementLogs = $this->InvolvementLogs()->where('created_at', '>', $activeSemester->start_date)->get();
        return $activeInvolvementLogs;
    }

    //Academics stuff
    public function academics()
    {
        return $this->hasMany(Academics::Class);
    }

    public function addAcademics(Academics $academics)
    {
        return $this->Academics()->create([
            'organization_id' => auth()->user()->organization->id,
        ]);
    }

    public function latestAcademics()
    {
        return $this->hasMany(Academics::Class)->latest()->first();
    }

    public function setPreviousData($prevGPA, $prevStanding)
    {        //Takes data on previous gpa and previous academic standing and saves it to the user
        $this->latestAcademics()->update([
            'Previous_Term_GPA' => $prevGPA,
            'Previous_Academic_Standing' => $prevStanding
        ]);
    }

    public function updateStanding()
    {
        $this->latestAcademics()->updateStanding();
    }

    public function checkAcademicRecords()
    {                  //Finds any entry in the database where it has the same name and organization as the new user and assigns the user id to it
        $match = [
            'name' => $this->name,
            'organization_id' => $this->organization_id
        ];


        $logs = Academics::where($match)->get();
        if ($logs->isNotEmpty()) {
            foreach ($logs as $log) {
                $prevGPA = $this->getPreviousAcademicData($this)['prevGPA'];
                $prevStanding = $this->getPreviousAcademicData($this)['prevStanding'];

                $log->update([
                    'user_id' => $this->id,
                ]);

                $this->setPreviousData($prevGPA, $prevStanding);
                $log->updateStanding();
            }
        }
    }

    public function getPreviousAcademicData()
    {
        /*
            If this is the very first entry an error will be thrown because the are no instances of academics.
            Then the method will return null and empty strings in order to allow the program to continue as expected
        */

        if ($this->latestAcademics() !== null) {
            return collect([
                'prevGPA' => $this->latestAcademics()->Current_Term_GPA,
                'prevStanding' => $this->latestAcademics()->Current_Academic_Standing,
            ]);
        } else {
            return collect([
                'prevGPA' => null,
                'prevStanding' => null,
            ]);
        }
    }

    //When a user user an invite link
    public function handleInvite(Organization $organization)
    {
        $this->join($organization);
        $this->setVerification(true);
        $this->setBasicUser();
    }

    //Invites for events
    public function hasInvitesRemaining(Event $event)
    {
        return $this->getInvitesRemaining($event) > 0;
    }

    public function getInvitesRemaining(Event $event)
    {
        $invitesPer = $event->num_invites;
        $match = [
            'user_id' => $this->id,
            'event_id' => $event->id,
        ];
        $invitesSent = DB::table('invites')->where($match)->count();
        return $invitesPer - $invitesSent;
    }

    public function getInvites(Event $event)
    {
        $match = [
            'user_id' => $this->id,
            'event_id' => $event->id,
        ];
        $invites = DB::table('invites')->where($match)->get();
        return $invites;
    }

    //Survey
    public function hasResponded(Survey $survey)
    {
        $answers = SurveyAnswers::where('survey_id', '=', $survey->id)->get();
        $answers->load('user');

        foreach ($answers as $answer) {
            if ($answer->user->id == auth()->id()) {
                return true;
            }
        }
        return false;
    }

    public function markAsAlumni()
    {
        $this->organization_verified = 2;
        $this->save();
    }

    public function invites()
    {
        return $this->hasMany(Invite::Class);
    }

    //Permissions getters
    public function canManageMembers()
    {
        return $this->role->permission->manage_member_details;
    }

    public function canManageInvolvement()
    {
        return $this->role->permission->manage_all_involvement;
    }

    public function canManageService()
    {
        return $this->role->permission->manage_all_service;
    }

    public function canViewMemberDetails()
    {
        return $this->role->permission->view_member_details;
    }

    public function canViewAllService()
    {
        return $this->role->permission->view_all_service;
    }

    public function canViewAllInvolvement()
    {
        return $this->role->permission->view_all_involvement;
    }

    public function canLogServiceEvent()
    {
        return $this->role->permission->log_service_event;
    }

    public function canManageEvents()
    {
        return $this->role->permission->manage_events;
    }

    public function canManageForum()
    {
        return $this->role->permission->manage_forum;
    }

    public function canManageAlumni()
    {
        return $this->role->permission->manage_alumni;
    }

    public function canTakeAttendance()
    {
        return $this->role->permission->take_attendance;
    }

    public function canManageSurveys()
    {
        return $this->role->permission->manage_surveys;
    }

    public function canViewAllStudy()
    {
        return $this->role->permission->view_all_study;
    }

    public function canManageAllStudy()
    {
        return $this->role->permission->manage_all_study;
    }

    public function canManageCalendar()
    {
        return $this->role->permission->manage_calendar;
    }

    public function isAdmin()
    {
        return $this->role->name == 'Admin';
    }
}
