<?php

namespace App\Listeners;

use App\Events\UserValidated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Academics;

class CheckForExistingAcademicModel
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
        $academics = Academics::where('name', $event->user->name)->get();
        foreach ($academics as $aca) {
            if (isset($aca)) {
                $event->user->academics()->save($aca);
            }
        }
    }
}
