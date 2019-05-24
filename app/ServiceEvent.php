<?php

namespace App;

use App\ServiceLog;
use Illuminate\Database\Eloquent\Model;

class ServiceEvent extends Model
{
    protected $guarded = [];

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
