<?php

namespace App\Listeners;

use App\Events\DuplicateGuestInvited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Commons\NotificationFunctions;

class DuplicatedGuestWasInvited
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
     * @param  DuplicateGuestInvited  $event
     * @return void
     */
    public function handle(DuplicateGuestInvited $event)
    {
        NotificationFunctions::alert('success', $event->invite->guest_name.' has already been invited.');
        return back();
    }
}
