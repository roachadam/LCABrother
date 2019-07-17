<?php

namespace App;

use App\ServiceLog;
use Illuminate\Database\Eloquent\Model;
use App\Commons\NotificationFunctions;
use App\User;

class ServiceEvent extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($ServiceEvent) {
            NotificationFunctions::alert('success', 'Updated service event details!');
            return back();
        });
    }

    public function setLog($attributes)
    {
        return $this->ServiceLogs()->create($attributes);
    }

    public function serviceLogs()
    {
        return $this->hasMany(Servicelog::class);
    }

    public function getAttendance()
    {
        $attendance = $this->serviceLogs->count();
        return $attendance;
    }

    public function userAttended(User $user)
    {
        $serviceLogs = $this->serviceLogs;
        return $serviceLogs->contains('user_id', $user->id);
    }
}
