<?php

namespace App\Listeners;

use App\Events\FailedToRecordAttendance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

class NotifyFailedRecordAttendance
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
     * @param  FailedToRecordAttendance  $event
     * @return void
     */
    public function handle(FailedToRecordAttendance $event)
    {
        NotificationFunctions::alert('success', $event->user->name . ' was already marked as attending for this event.');
    }
}
