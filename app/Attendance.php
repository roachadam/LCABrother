<?php

namespace App;

use App\AttendanceEvent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function attendanceEvent(){
        return $this->belongsTo(AttendanceEvent::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
