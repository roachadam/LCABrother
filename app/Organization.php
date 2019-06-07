<?php

namespace App;

use App\Role;
use App\User;
use App\Goals;
use App\ServiceEvent;
use App\Involvement;
use App\Event;
use DevDojo\Chatter\Models\Discussion;
use DevDojo\Chatter\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function discussion()
    {
        return $this->hasMany(Discussion::class);
    }
    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function addRole($name)
    {
        return $this->roles()->create(['name' =>$name]);
    }

    public function createAdmin()
    {
        $role = $this->addRole('Admin');
        $role->setAdminPermissions();
    }

    public function createBasicUser()
    {
        $role = $this->addRole('Basic');
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

    public function addEvent($attributes){
        return $this->event()->create($attributes);
    }
    public function event()
    {
        return $this->hasMany(Event::Class);
    }

    public function getAverages(){
        $users = $this->users;
        $attributes = [];
        $count = 0;
        $tempService = 0;
        $tempMoney = 0;
        $tempPoints = 0;
        foreach($users as $user){
            $count++;
            $tempService += $user->getServiceHours();
            $tempMoney += $user->getMoneyDonated();
            $tempPoints += $user->getInvolvementPoints();
        }
        $attributes['service'] = $tempService/$count;
        $attributes['money'] = $tempMoney/$count;
        $attributes['points'] = $tempPoints/$count;

        return $attributes;
    }
    public function getTotals(){
        $users = $this->users;
        $attributes = [];
        $count = 0;
        $tempService = 0;
        $tempMoney = 0;
        $tempPoints = 0;
        foreach($users as $user){
            $count++;
            $tempService += $user->getServiceHours();
            $tempMoney += $user->getMoneyDonated();
            $tempPoints += $user->getInvolvementPoints();
        }
        $attributes['service'] = $tempService;
        $attributes['money'] = $tempMoney;
        $attributes['points'] = $tempPoints;

        return $attributes;
    }

    public function getArrayOfServiceHours(){
        $users = $this->users;
        $attributes = [];
        $count = 0;
        $collection = collect();
        foreach($users as $user){
            $collection->push($user->getServiceHours());
        }
        return $collection->toArray();
    }

}
