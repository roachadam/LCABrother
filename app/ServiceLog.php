<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ServiceEvent;
use App\Commons\NotificationFunctions;

class ServiceLog extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($ServiceEvent) {
            NotificationFunctions::alert('success', 'Logged Service Event!');
            return back();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceEvent()
    {
        return $this->belongsTo(ServiceEvent::class);
    }
}
