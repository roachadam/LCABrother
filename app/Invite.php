<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function event()
    {
        return $this->belongsTo(Event::Class);
    }
}
