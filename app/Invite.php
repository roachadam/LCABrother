<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::created(function ($invite)
        {
            session()->put('success', $invite->guest_name.' has been invited!');
            return back();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function event()
    {
        return $this->belongsTo(Event::Class);
    }
}
