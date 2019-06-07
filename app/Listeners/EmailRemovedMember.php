<?php

namespace App\Listeners;

use App\Events\MemberRemovedFromOrg;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\MemberRemoved;
use App\User;

class EmailRemovedMember
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
     * @param  MemberRemovedFromOrg  $event
     * @return void
     */
    public function handle(MemberRemovedFromOrg $event)
    {
        Mail::to($event->user->email)->send(
            new MemberRemoved($event->user, auth()->user()->organization)
        );
    }
}
