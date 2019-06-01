<?php

namespace App;

use App\ServiceLog;
use Illuminate\Database\Eloquent\Model;

class ServiceEvent extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($ServiceEvent)
        {
            session()->put('success', 'Logged Service Event!');
            return back();
        });

        static::updated(function ($ServiceEvent)
        {
            session()->put('success', 'Updated service event details!');
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
