<?php

namespace App;

use App\AttendanceEvent;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Attendance extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($Attendance) {
            $newMsg = 'Attendance log(s) deleted!';
            if (Session::has('primary')) {
                $msgs = Session('primary');

                $alreadyInSession = false;

                if (!$alreadyInSession) {
                    array_push($msgs, $newMsg);
                    Session()->forget('primary');
                    Session()->put('primary', $msgs);
                }
            } else {
                Session()->put('primary', array($newMsg));
            }
        });
        return back();
    }

    public function attendanceEvent()
    {
        return $this->belongsTo(AttendanceEvent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
