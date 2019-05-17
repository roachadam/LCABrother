<?php

namespace App;

use App\Role;
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
        'name', 'email', 'password','phone'
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

        $this->role()->associate($role)->save();
    }
    public function setAdmin()
    {
        $role = $this->organization->roles[0];

        $this->role()->associate($role)->save();
    }

    public function role(){
        return $this->belongsTo(Role::Class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }
}
