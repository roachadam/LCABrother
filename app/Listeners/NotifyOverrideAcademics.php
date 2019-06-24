<?php

namespace App\Listeners;

use App\Events\OverrideAcademics;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Commons\NotificationFunctions;

class NotifyOverrideAcademics
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
     * @param  OverrideAcademics  $event
     * @return void
     */
    public function handle(OverrideAcademics $event)
    {
        $newMsg = 'Successfully overrode ' . $event->user->name . '\'s academic records!';
        NotificationFunctions::alert('success', $newMsg);
    }
}
