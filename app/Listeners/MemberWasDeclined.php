<?php

namespace App\Listeners;

use App\Events\MemberDeclined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Commons\NotificationFunctions;
class MemberWasDeclined
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
     * @param  MemberDeclined  $event
     * @return void
     */
    public function handle(MemberDeclined $event)
    {

        NotificationFunctions::alert('success', 'You have successfully declined '.$event->user->name);

        return back();
    }
}
