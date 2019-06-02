<?php

namespace App\Listeners;

use App\Events\GoalsNotifSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        if($event->sent)
            session()->put('success','Emails sent successfully');
        else
            session()->put('info','No members below threshhold');
        return back();
    }
}
