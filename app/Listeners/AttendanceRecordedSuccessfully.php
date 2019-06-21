<?php

namespace App\Listeners;

use App\Events\AttendanceRecorded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

class AttendanceRecordedSuccessfully
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AttendanceRecorded  $event
     * @return void
     */
    public function handle(AttendanceRecorded $event)
    {
        if(Session::has('success')){
            $msgs = Session('success');
            array_push($msgs, 'Attendance Was Recorded');
            Session()->forget('success');
            Session()->put('success', $msgs);
        }else{
            $msgs = [
                'Attendance Was Recorded'
            ];
            Session()->put('success', $msgs);
        }
    }
}
