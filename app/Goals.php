<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commons\NotificationFunctions;

class Goals extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($Goals)
        {
            NotificationFunctions::alert('success', 'Set organization goals.');
            return back();
        });
        static::updated(function ($Goals)
        {
            NotificationFunctions::alert('success', 'Updated organization goals.');
            return back();
        });
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::Class);
    }
}
