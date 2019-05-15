<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'owner_id'
    ];

    public function members(){
        return $this->hasMany((User::class));
    }

    public function setOwner(User $user){
        $this->owner_id = $user->id;
        $this->save();
    }

}
