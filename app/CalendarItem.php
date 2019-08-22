<?php

namespace App;

use App\Organization;
use App\Event;
use App\AttendanceEvent;
use App\CalendarCatagory;
use Illuminate\Database\Eloquent\Model;

class CalendarItem extends Model
{
    protected $guarded = [];
    protected $table = 'calendar';

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function attendanceEvent(){
        return $this->hasOne(AttendanceEvent::class);
    }
    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function hasEvent(){
        return $this->event_id !== null;
    }
}
