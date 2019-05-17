<?php

namespace App;

use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    protected $fillable = [
        'name', 'owner_id'
    ];

    public function addRole($attributes){
        return $this->roles()->create($attributes);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function roles(){
        return $this->hasMany(Role::class);
    }
}
