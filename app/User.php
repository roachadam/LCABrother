<?php

namespace App;

use App\Role;
use App\ServiceLog;
use App\InvolvementLog;
use App\Academics;
use App\Event;
use App\Invite;
use App\Tasks;
use App\TaskAssignments;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    protected $fillable = [
        'zeta_number', 'name', 'email', 'major', 'password', 'phone', 'organization_verified', 'organization_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Static helper functions
    public static function findByName($name, $organizationId = null): ?User
    {
        return isset($organizationId) ? (self::where(['organization_id' => $organizationId, 'name' => $name,])->first()) : self::where('name', $name)->first();
    }

    public static function findById($id, $organizationId = null): ?User
    {
        return isset($organizationId) ? (self::where(['organization_id' => $organizationId, 'id' => $id,])->first()) : self::where('id', $id)->first();
    }

    public static function findAll($organizationId = null): ?Collection
    {
        return isset($organizationId) ? (self::where(['organization_id' => $organizationId])->get()) : self::all();
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
        return $this->organization_verified === 1 || $this->organization_verified === 3;
    }

    public function isAssociate()
    {
        return $this->organization_verified === 3;
    }

    public function setAssociate()
    {
        return $this->update([
            'organization_verified' => 3,
        ]);
    }

    public function isActive()
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
        return $this->serviceLogs()->where('created_at', '>', $this->organization->getActiveSemester()->start_date)->get();
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
        return $this->InvolvementLogs()->where('created_at', '>', $this->organization->getActiveSemester()->start_date)->get();
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
        $invitesSent = Invite::where($match)->count();
        return $invitesPer - $invitesSent;
    }

    public function getInvites(Event $event)
    {
        $match = [
            'user_id' => $this->id,
            'event_id' => $event->id,
        ];
        $invites = Invite::where($match)->get();
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

    // public function tasks()
    // {
    //     return $this->hasMany(Tasks::class);
    // }

    public function getIncompleteTasks()
    {
        $match = [
            'assignee_id' => $this->id,
            'completed' => 0,
        ];
        $tasks = TaskAssignments::where($match)->get();
        return $tasks;
    }

    public function getCompleteTasks()
    {
        $match = [
            'assignee_id' => $this->id,
            'completed' => 1,
        ];
        return TaskAssignments::where($match)->get();
    }

    public function getTasksAssigned()
    {
        return Tasks::where('user_id', '=', $this->id)->get();
    }
    public function assignedTasks()
    {
        return $this->hasMany(TaskAssignments::class);
    }

    //Permissions getters
    public function canManageMembers()
    {
        return $this->role->permission->manage_member_details;
    }

    public function canViewMembers()
    {
        return $this->role->permission->view_member_details || $this->canManageMembers();
    }

    public function canManageInvolvement()
    {
        return $this->role->permission->manage_all_involvement;
    }

    public function canManageService()
    {
        return $this->role->permission->manage_all_service;
    }

    public function canViewAllService()
    {
        return $this->role->permission->view_all_service || $this->canManageService();
    }

    public function canViewAllInvolvement()
    {
        return $this->role->permission->view_all_involvement || $this->canManageInvolvement();
    }

    public function canLogServiceEvent()
    {
        return $this->role->permission->log_service_event;
    }

    public function canManageEvents()
    {
        return $this->role->permission->manage_events;
    }


    public function canManageAlumni()
    {
        return $this->role->permission->manage_alumni;
    }

    public function canManageAttendance()
    {
        return $this->role->permission->manage_attendance;
    }

    public function canTakeAttendance()
    {
        return $this->role->permission->take_attendance || $this->role->permission->manage_attendance;
    }

    public function canManageSurveys()
    {
        return $this->role->permission->manage_surveys;
    }

    public function canManageAllStudy()
    {
        return $this->role->permission->manage_all_study;
    }

    public function canViewAllStudy()
    {
        return $this->role->permission->view_all_study || $this->canManageAllStudy();
    }

    public function canManageCalendar()
    {
        return $this->role->permission->manage_calendar;
    }

    public function canManageGoals()
    {
        return $this->role->permission->manage_goals;
    }

    public function isAdmin()
    {
        return $this->role->name == 'Admin';
    }
}
