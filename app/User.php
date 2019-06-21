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

    public function setPreviousData($prevGPA, $prevStanding)        //Takes data on previous gpa and previous academic standing and saves it to the user
    {
        $this->latestAcademics()->update([
            'Previous_Term_GPA' => $prevGPA,
            'Previous_Academic_Standing' => $prevStanding
        ]);
    }

    public function updateStanding($storedAcademics = null, $entry = null)          //TODO fix overriding shit
    {
        /*
            Checks if this method is being used for updating previous database entries (returns $entry)
            or if called when a new file is uploaded (returns $this->latestAcademics())
        */
        $academics = isset($entry) ? $entry : $this->latestAcademics();

        $org = auth()->user()->organization;
        $standingsOuter = $org->getStandingsAsc();
        $standingsInner = $org->getStandingsDsc();

        $hitOuter = false;
        $found = false;
        $readyToSet = false;
        $passedOuter = false;
        $prevTermIndex = 0;
        /*
            standings [
                good 2.5 - prev
                risk 2.0 - new standing
                probation 1.5 -current
                bad 1.0
            ]
        */
        $standingsOuter = $standingsOuter->all();

        for ($i = 0; $i < count($standingsOuter); $i++) {
            $outer = $standingsOuter[$i];
            if ($outer->name == $academics->Previous_Academic_Standing) {
                $prevTermIndex = $i;
            }

            if ($this->check($outer, $academics)) {
                if ($academics->Previous_Academic_Standing === null || $academics->Previous_Academic_Standing === "") {
                    $this->setTo($outer->name, $academics);
                    break;
                }
                foreach ($standingsInner as $inner) {
                    if ($hitOuter) {
                        $passedOuter = true;
                    }

                    if ($outer->name == $inner->name) {   //Check if crossed middle
                        $hitOuter = true;
                    }

                    if ($hitOuter) {                    //Step down
                        if (!$passedOuter) {
                            $this->setTo($inner->name, $academics);
                            break;
                        } else {
                            $this->setTo($standingsOuter[$prevTermIndex + 1]->name, $academics);
                            break;
                        }
                    } else {                            //Step up
                        if ($readyToSet) {
                            $this->setTo($inner->name, $academics);
                            break;
                        }
                        if ($inner->name == $academics->Previous_Academic_Standing) {
                            $readyToSet = true;
                        }
                    }
                }
                break;
            }
        }
    }

    public function setTo($name, $academics)
    {
        $academics->update([
            'Current_Academic_Standing' => $name
        ]);
    }

    public function check(AcademicStandings $standing, $academics): bool
    {
        return $academics->Current_Term_GPA > $standing->Term_GPA_Min;
    }

    public function checkAcademicRecords()          //Finds any entry in the database where it has the same name and organization as the new user and assigns the user id to it
    {
        $match = [                                  //The attributes that will be searched for when querying the database for the previous logs
            'name' => $this->name,
            'organization_id' => $this->organization_id
        ];

        $logs = Academics::where($match)->get();                   //Finds all the previous logs for the user and returns a collection
        if ($logs->isNotEmpty()) {                                 //Checks if the collection is empty (Meaning there are no previous logs)
            foreach ($logs as $entry) {                            //Loops through each entry in the logs collection
                $entry->update([                                   //Assigns the user's id to each log
                    'user_id' => $this->id,
                ]);
                $this->updateStanding(null, $entry);                                //Initializes the initial standing of the log
                $prevAcademics = $this->academics()->latest()->skip(1)->first();    //Gets a reference to the second latest academics
                if ($prevAcademics !== null) {                                      //If this is the first entry $prevAcademics will be null so there is nothing to save as previous data so just leave it blank
                    $this->setPreviousData($prevAcademics->Current_Term_GPA, $prevAcademics->Current_Academic_Standing);    //Sets the previous GPA and Standing data
                }
            }
        }
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
