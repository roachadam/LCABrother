<?php

namespace App;

use App\Role;
use App\User;
use App\Goals;
use App\ServiceEvent;
use App\Involvement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function addRole($attributes)
    {
        return $this->roles()->create($attributes);
    }

    public function createAdmin()
    {
        $attributes = [
            'name'  =>'admin'
        ];
        $role = $this->addRole($attributes);
        $role->setAdminPermissions();
    }

    public function createBasicUser()
    {
        $attributes = [
            'name'  =>'basic'
        ];
        $role = $this->addRole($attributes);
        $role->setBasicPermissions();
    }
    public function getVerifiedMembers(){
        $members = $this->users()->where('organization_verified',1)->get();
        return $members;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function setGoals($attributes){
        $goals = Goals::create($attributes);
        $this->goals()->save($goals);
    }

    public function goals(){
        return $this->hasOne(Goals::class);
    }
    public function serviceEvents()
    {
        return $this->hasMany(ServiceEvent::Class);
    }
    public function addInvolvementEvent($attributes){
        return $this->involvement()->create($attributes);
    }
    public function involvement()
    {
        return $this->hasMany(Involvement::Class);
    }
}
