<?php

namespace App;

use App\Role;
use App\ServiceLog;
use App\InvolvementLog;
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
        'name', 'email', 'password','phone','organization_verified', 'organization_id'
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

        static::updated(function ($User)
        {
            session()->put('success', 'Updated your details!');
            return back();
        });
    }

    public function setBasicUser(){
        $role = $this->organization->roles[1];

        $this->setRole($role);
    }
    public function setAdmin(){
        $role = $this->organization->roles[0];
        $this->setRole($role);
    }

    public function setRole($role){
        $this->role()->associate($role)->save();
    }

    public function role(){
        return $this->belongsTo(Role::Class);
    }

    public function join($org){
        $this->organization()->associate($org)->save();
    }

    public function setVerification($verified){

        if($verified)
        {
            $attributes = ['organization_verified' => $verified];
        }
        else
        {

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

    public function isVerified(){
        if($this->organization_verified ===1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getMoneyDonated(){
        $logs = $this->serviceLogs;
        $cash =0;
        foreach($logs as $log){
            $cash+= $log->money_donated;
        }

        return $cash;
    }
    public function getServiceHours(){
        $logs = $this->serviceLogs;
        $hours =0;
        foreach($logs as $log){
            $hours+= $log->hours_served;
        }
        return $hours;
    }
    public function serviceLogs(){
        return $this->hasMany(ServiceLog::Class);
    }
    public function addInvolvementLog(Involvement $involvement, $date){
        return $this->InvolvementLogs()->create([
            'organization_id' => auth()->user()->organization->id,
            'involvement_id' => $involvement->id,
            'date_of_event' => $date,
        ]);
    }

    public function getInvolvementPoints(){
        $InvolvementLogs = $this->InvolvementLogs;
        $points =0;
        foreach($InvolvementLogs as $log){
            $points+= $log->involvement->points;
        }
        return $points;
    }
    public function InvolvementLogs(){
        return $this->hasMany(InvolvementLog::Class);
    }

    public function handleInvite(Organization $organization){
        $this->join($organization);
        $this->setVerification(true);
        $this->setBasicUser();
    }

    public function hasInvitesRemaining(Event $event){
        if($this->getInvitesRemaining($event) > 0)
        {
            return true;
        }
        else
        {
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
}
