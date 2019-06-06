<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academics extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Academics) {
            session()->put('success', 'Created new Academic!');
            return back();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
