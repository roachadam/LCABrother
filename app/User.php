<?php

namespace App;

use App\Role;
use App\ServiceLog;
use App\InvolvementLog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','organization_verified', 'organization_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
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
    public function getServiceHours(){
        $serviceHours = $this->serviceHours;
        $hours =0;
        foreach($serviceHours as $hour){
            $hours+= $hour->hours_served;
        }

        return $hours;
    }
    public function serviceHours(){
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
}
