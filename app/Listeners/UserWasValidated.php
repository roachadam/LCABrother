<?php

namespace App\Listeners;

use App\Events\UserValidated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Commons\NotificationFunctions;
class UserWasValidated
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
     * @param  UserValidated  $event
     * @return void
     */
    public function handle(UserValidated $event)
    {
        NotificationFunctions::alert('success', 'You have successfully validated '.$event->user->name);
        return back();
    }
}
