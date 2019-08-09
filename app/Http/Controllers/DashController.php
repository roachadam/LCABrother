<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestAcademics = $user->latestAcademics();

        $moneyDonated = $user->getMoneyDonated();
        $hoursServed = $user->getServiceHours();
        $gpa = isset($latestAcademics) ? round($latestAcademics->Current_Term_GPA, 2) : 'N/A';
        $points = $user->getInvolvementPoints();

        $unAnsweredSurveys = $user->organization->survey->filter(function ($survey) use ($user) {
            return !$user->hasResponded($survey);
        });

        $eventsWithInvites = $user->organization->event->filter(function ($event) use ($user) {
            return $user->hasInvitesRemaining($event);
        });

        return view('main.dash', compact('user', 'moneyDonated', 'hoursServed', 'gpa', 'points', 'unAnsweredSurveys', 'eventsWithInvites'));
    }
}
