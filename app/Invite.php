<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::Class);
    }
}
