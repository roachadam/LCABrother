<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Goals)
        {
            session()->put('success', 'Set organization goals.');
            return back();
        });
    }
    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }
}
