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
            NotificationFunctions::alert('success', 'Updated your details!');
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

    public function getActiveServiceLogs(){
        $activeSemester = $this->organization->getActiveSemester();
        $activeServiceLogs = $this->serviceLogs()->where('created_at', '>', $activeSemester->start_date)->get();
        return $activeServiceLogs;
    }

    // Involvement Logs
    public function InvolvementLogs(){
        return $this->hasMany(InvolvementLog::Class);
    }
    public function addInvolvementLog(Involvement $involvement, $date){
        return $this->InvolvementLogs()->create([
            'organization_id' => auth()->user()->organization->id,
            'involvement_id' => $involvement->id,
            'date_of_event' => $date,
        ]);
    }
    public function getInvolvementPoints(){
        $InvolvementLogs = $this->getActiveInvolvementLogs();
        $points = 0;
        foreach ($InvolvementLogs as $log) {
            $points += $log->involvement->points;
        }
        return $points;
    }
    public function getActiveInvolvementLogs(){
        $activeSemester = $this->organization->getActiveSemester();
        $activeInvolvementLogs = $this->InvolvementLogs()->where('created_at', '>', $activeSemester->start_date)->get();
        return $activeInvolvementLogs;
    }

    //Academics stuff
    public function academics(){
        return $this->hasMany(Academics::Class);
    }
    public function addAcademics(Academics $academics){
        return $this->Academics()->create([
            'organization_id' => auth()->user()->organization->id,
        ]);
    }
    public function latestAcademics(){
        return $this->hasMany(Academics::Class)->latest()->first();
    }

    public function setPreviousData($prevGPA, $prevStanding){        //Takes data on previous gpa and previous academic standing and saves it to the user
        $this->latestAcademics()->update([
            'Previous_Term_GPA' => $prevGPA,
            'Previous_Academic_Standing' => $prevStanding
        ]);
    }

    public function updateStanding(){
        $this->latestAcademics()->updateStanding();
    }

    public function checkAcademicRecords(){                  //Finds any entry in the database where it has the same name and organization as the new user and assigns the user id to it
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

    public function getPreviousAcademicData(){
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
    public function handleInvite(Organization $organization){
        $this->join($organization);
        $this->setVerification(true);
        $this->setBasicUser();
    }

    //Invites for events
    public function hasInvitesRemaining(Event $event){
        if ($this->getInvitesRemaining($event) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getInvitesRemaining(Event $event){
        $invitesPer = $event->num_invites;
        $match = [
            'user_id' => $this->id,
            'event_id' => $event->id,
        ];
        $invitesSent = DB::table('invites')->where($match)->count();
        return $invitesPer - $invitesSent;
    }

    public function getInvites(Event $event){
        $match = [
            'user_id' => $this->id,
            'event_id' => $event->id,
        ];
        $invites = DB::table('invites')->where($match)->get();
        return $invites;
    }

    //Survey
    public function hasResponded(Survey $survey){
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
    public function canManageMembers(){
        $Can = $this->role->permission->manage_member_details;
        return $Can;
    }
    public function canManageInvolvment(){
        $Can = $this->role->permission->manage_all_involvement;
        return $Can;
    }
    public function canManageService(){
        $Can = $this->role->permission->manage_all_service;
        return $Can;
    }
    public function canViewMemberDetails(){
        $Can = $this->role->permission->view_member_details;
        return $Can;
    }
    public function canViewAllService(){
        $Can = $this->role->permission->view_all_service;
        return $Can;
    }
    public function canViewAllInvolvement(){
        $Can = $this->role->permission->view_all_involvement;
        return $Can;
    }
    public function canLogServiceEvent(){
        $Can = $this->role->permission->log_service_event;
        return $Can;
    }
    public function canManageEvents(){
        $Can = $this->role->permission->manage_events;
        return $Can;
    }
    public function canManageForum(){
        $Can = $this->role->permission->manage_forum;
        return $Can;
    }
    public function canManageSurveys(){
        $Can = $this->role->permission->manage_surveys;
        return $Can;
    }
    public function canViewAllStudy(){
        $Can = $this->role->permission->view_all_study;
        return $Can;
    }
    public function canManageAllStudy(){
        $Can = $this->role->permission->manage_all_study;
        return $Can;
    }
    public function canManageCalendar(){
        $Can = $this->role->permission->manage_calendar;
        return $Can;
    }
}
