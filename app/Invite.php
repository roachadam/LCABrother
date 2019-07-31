<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commons\NotificationFunctions;

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
