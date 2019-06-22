<?php

namespace App\Providers;

use App\Providers\MemberRemovedFromOrg;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        //
    }
}
