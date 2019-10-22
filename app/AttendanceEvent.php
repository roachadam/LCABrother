<?php

namespace App;

use App\Attendance;
use App\CalendarItem;
use App\Involvement;
use Illuminate\Database\Eloquent\Model;


class AttendanceEvent extends Model
{
    protected $guarded = [];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function addAttendance($attributes)
    {
        return $this->attendance()->create($attributes);
    }

    public function calendarItem()
    {
        return $this->belongsTo(CalendarItem::class);
    }
    public function involvement()
    {
        return $this->belongsTo(Involvement::class);
    }

    public function getUsersNotInAttendance()
    {
        $users = (env('APP_ENV') === 'testing') ? User::where('organization_id', auth()->user()->organization_id)->get() : auth()->user()->organization->getActiveMembers();
        $attending = $this->getUsersInAttendance();
        return $users->diff($attending);
    }

    public function getUsersInAttendance()
    {
        $attendances = Attendance::where('attendance_event_id', $this->id)->get();

        $attending = collect();
        foreach ($attendances as $attendance) {
            $user = $attendance->user;
            $attending->push($user);
        }
        return $attending;
    }
}
