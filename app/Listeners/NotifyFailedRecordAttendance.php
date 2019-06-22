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
        $newMsg = $event->user->name . ' was already marked as attending for this event.';
            if(Session::has('error')){
                $msgs = Session('error');

                $alreadyInSession = false;

                if(!$alreadyInSession){
                    array_push($msgs, $newMsg);
                Session()->forget('error');
                Session()->put('error', $msgs);
                }

            }else{
                Session()->put('error', array($newMsg));
            }
    }
}
