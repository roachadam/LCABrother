<?php

namespace App;

use App\ServiceLog;
use Illuminate\Database\Eloquent\Model;
use App\Commons\NotificationFunctions;

class ServiceEvent extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($ServiceEvent)
        {
            NotificationFunctions::alert('success', 'Logged Service Event!');
            return back();
        });

        static::updated(function ($ServiceEvent)
        {
            NotificationFunctions::alert('success', 'Updated service event details!');
            return back();
        });
    }

    public function setLog($attributes){
        return $this->ServiceLogs()->create($attributes);
    }
    public function ServiceLogs(){
        return $this->hasMany(Servicelog::class);
    }
    public function getAttendance(){
        $attendance = $this->ServiceLogs->count();
        return $attendance;
    }
}
