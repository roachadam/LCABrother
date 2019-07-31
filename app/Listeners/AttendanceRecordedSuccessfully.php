<?php

namespace App\Listeners;

use App\Events\AttendanceRecorded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Commons\NotificationFunctions;

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
        NotificationFunctions::alert('success', 'Attendance Was Recorded!');
        return back();
    }
}
