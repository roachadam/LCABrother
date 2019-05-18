<?php

namespace App;

use App\Role;
use App\User;
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
    public function serviceEvents()
    {
        return $this->hasMany(ServiceEvent::Class);
    }
    public function involvement()
    {
        return $this->hasMany(Involvement::Class);
    }
}
