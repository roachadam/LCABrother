<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $moneyDontated = $user->getMoneyDonated();
        $hoursServed = $user->getServiceHours();
        $gpa = $user->latestAcademics()->Current_Term_GPA ?? 'N/A';
        $points = $user->getInvolvementPoints();

        if($gpa != 'N/A')
            $gpa = round($gpa, 2);


        // Surveys
        $surveys = $user->organization->survey;
        if(isset($surveys))
        {

            $unAnsweredSurveys = collect();
            foreach($surveys as $survey)
            {
                if(!$user->hasResponded($survey))
                {
                    $unAnsweredSurveys->push($survey);
                }
            }
        }


        // Invites/events
        $events = $user->organization->event;
        if(isset($events))
        {
            $eventsWithInvites = collect();
            foreach($events as $event)
            {
                if($user->hasInvitesRemaining($event))
                    $eventsWithInvites->push($event);
            }
        }

        return view('main.dash', compact('user', 'points', 'moneyDontated', 'hoursServed', 'gpa', 'unAnsweredSurveys', 'eventsWithInvites'));
    }
}
