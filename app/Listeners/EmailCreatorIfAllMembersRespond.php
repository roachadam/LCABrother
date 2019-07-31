<?php

namespace App\Listeners;

use App\Events\MemberAnsweredSurvey;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Survey;
use App\Mail\SurveyCompleted;
use Mail;

class EmailCreatorIfAllMembersRespond
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
     * @param  MemberAnsweredSurvey  $event
     * @return void
     */
    public function handle(MemberAnsweredSurvey $event)
    {
        if ($event->survey->getAllUnansweredMembers()->count() == 0) {
            Mail::to($event->survey->user)->send(
                new SurveyCompleted($event->survey)
            );
        }
    }
}
