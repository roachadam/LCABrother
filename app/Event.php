<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
use App\Invite;
class Event extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }

    public function addInvite($attributes){
        return $this->invites()->create($attributes);
    }

    public function invites()
    {
        return $this->hasMany(Invite::Class);
    }
}
