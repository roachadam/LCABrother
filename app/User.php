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

class User extends Authenticatable
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
            session()->put('success', 'Updated your details!');
            return back();
        });
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
        if ($this->organization_verified === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getMoneyDonated()
    {
        $logs = $this->serviceLogs;
        $cash = 0;
        foreach ($logs as $log) {
            $cash += $log->money_donated;
        }

        return $cash;
    }
    public function getServiceHours()
    {
        $logs = $this->serviceLogs;
        $hours = 0;
        foreach ($logs as $log) {
            $hours += $log->hours_served;
        }
        return $hours;
    }
    public function serviceLogs()
    {
        return $this->hasMany(ServiceLog::Class);
    }
    public function addInvolvementLog(Involvement $involvement, $date)
    {
        return $this->InvolvementLogs()->create([
            'organization_id' => auth()->user()->organization->id,
            'involvement_id' => $involvement->id,
            'date_of_event' => $date,
        ]);
    }

    public function getInvolvementPoints()
    {
        $InvolvementLogs = $this->InvolvementLogs;
        $points = 0;
        foreach ($InvolvementLogs as $log) {
            $points += $log->involvement->points;
        }
        return $points;
    }

    public function InvolvementLogs()
    {
        return $this->hasMany(InvolvementLog::Class);
    }

    //Academics stuff
    public function addAcademics(Academics $academics)
    {
        return $this->Academics()->create([
            'organization_id' => auth()->user()->organization->id,
        ]);
    }

    public function academics()
    {
        return $this->hasMany(Academics::Class);
    }

    public function latestAcademics()
    {
        return $this->hasMany(Academics::Class)->latest()->first();
    }

    public function setPreviousData($prevGPA, $prevStanding)
    {
        $academics = $this->latestAcademics();
        $academics->Previous_Term_GPA = $prevGPA;
        $academics->Previous_Academic_Standing = $prevStanding;
        $academics->save();
    }

    public function updateStanding($previousAcademics = null, $overridden = false, $entry = null)
    {
        //Checks if this method is being used for updating previous database entries (returns $entry)
        //or if called when a new file is uploaded (returns $this->latestAcademics())
        $academics = isset($entry) ? $entry : $this->latestAcademics();

        /*
            Requirements to increase standing:
                Suspension -> Probation: GPA & Cumulative GPA >= 2.5 and previous standing of Suspension
                Probation -> Good: GPA & Cumulative GPA 2.5 >= and previous standing of Probation
            Requirements to decrease standing:
                Good -> Probation: 2.5 > GPA || Cumulative GPA > 1.0 and previous standing of Good
                Good -> Suspension: GPA || Cumulative GPA <= 1.0 and previous standing doesn't matter
                Probation -> Suspension: GPA || Cumulative GPA <= 2.5 and previous standing of Probation
        */

        if (!$overridden && !isset($previousAcademics)) {
            if ($academics->Current_Term_GPA > 2.5 && $academics->Cumulative_GPA > 2.5) {
                if ($academics->Previous_Academic_Standing === 'Suspension') {
                    $this->setToProbation($academics);
                } else {
                    $this->setToGood($academics);
                }
            } else if ($academics->Current_Term_GPA > 1.0 && $academics->Cumulative_GPA > 1.0) {
                if ($academics->Previous_Academic_Standing === 'Good' || $academics->Previous_Academic_Standing === null || $academics->Previous_Academic_Standing === "") {
                    $this->setToProbation($academics);
                } else {
                    $this->setToSuspension($academics);
                }
            } else {
                $this->setToSuspension($academics);
            }
        } else {
            if (!($academics->Previous_Term_GPA === $previousAcademics->Previous_Term_GPA && $academics->Current_Term_GPA === $previousAcademics->Current_Term_GPA && $academics->Cumulative_GPA === $previousAcademics->Cumulative_GPA)) {
                self::updateStanding();
            }
        }
    }

    public function checkAcademicRecords()              //Finds any entry in the database where it has the same name and organization as the new user and assigns the user id to it
    {
        $match = [
            'name' => $this->name,
            'organization_id' => $this->organization_id
        ];

        $logs = Academics::where($match)->get();
        if ($logs->isNotEmpty()) {
            foreach ($logs as $entry) {
                $entry->update([
                    'user_id' => $this->id,
                ]);
                $this->updateStanding(null, false, $entry);
                $prevAcademics = $this->academics()->latest()->skip(1)->first();
                if ($prevAcademics !== null) {
                    $this->setPreviousData($prevAcademics->Current_Term_GPA, $prevAcademics->Current_Academic_Standing);
                }
            }
        }
    }

    public function setToSuspension(Academics $academics)
    {
        $academics->Current_Academic_Standing = 'Suspension';
        $academics->save();
    }

    public function setToGood(Academics $academics)
    {
        $academics->Current_Academic_Standing = 'Good';
        $academics->save();
    }

    public function setToProbation(Academics $academics)
    {
        $academics->Current_Academic_Standing = 'Probation';
        $academics->save();
    }

    public function handleInvite(Organization $organization)
    {
        $this->join($organization);
        $this->setVerification(true);
        $this->setBasicUser();
    }

    public function hasInvitesRemaining(Event $event)
    {
        if ($this->getInvitesRemaining($event) > 0) {
            return true;
        } else {
            return false;
        }
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
        $Can = $this->role->permission->manage_member_details;
        return $Can;
    }
    public function canManageInvolvment()
    {
        $Can = $this->role->permission->manage_all_involvement;
        return $Can;
    }
    public function canManageService()
    {
        $Can = $this->role->permission->manage_all_service;
        return $Can;
    }
    public function canViewMemberDetails()
    {
        $Can = $this->role->permission->view_member_details;
        return $Can;
    }
    public function canViewAllService()
    {
        $Can = $this->role->permission->view_all_service;
        return $Can;
    }
    public function canViewAllInvolvement()
    {
        $Can = $this->role->permission->view_all_involvement;
        return $Can;
    }
    public function canLogServiceEvent()
    {
        $Can = $this->role->permission->log_service_event;
        return $Can;
    }
    public function canManageEvents()
    {
        $Can = $this->role->permission->manage_events;
        return $Can;
    }
    public function canManageForum()
    {
        $Can = $this->role->permission->manage_forum;
        return $Can;
    }
    public function canManageSurveys()
    {
        $Can = $this->role->permission->manage_surveys;
        return $Can;
    }
    public function canViewAllStudy()
    {
        $Can = $this->role->permission->view_all_study;
        return $Can;
    }
    public function canManageAllStudy()
    {
        $Can = $this->role->permission->manage_all_study;
        return $Can;
    }
    public function canManageCalendar()
    {
        $Can = $this->role->permission->manage_calendar;
        return $Can;
    }
}
