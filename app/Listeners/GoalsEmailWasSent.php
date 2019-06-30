<?php

namespace App\Listeners;

use App\Events\GoalsNotifSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Commons\NotificationFunctions;

class GoalsEmailWasSent
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
     * @param  GoalsNotifSent  $event
     * @return void
     */
    public function handle(GoalsNotifSent $event)
    {
        if($event->sent){
            NotificationFunctions::alert('success','Members Notified!');
        }
        else
            NotificationFunctions::alert('success', 'No members below threshhold');

        return back();
    }
}
