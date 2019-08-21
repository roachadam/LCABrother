<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ServiceHoursChart;

class TotalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageGoals');
    }

    public function index()
    {
        $organization = auth()->user()->organization;
        $users = $organization->getVerifiedMembers();
        $serviceHoursArray = $organization->getArrayOfServiceHours();


        $totals = $organization->getTotals();
        $averages = $organization->getAverages();
        $goals = $organization->goals;

        $numMembers = $organization->getVerifiedMembers()->count();
        $sumTotals['service'] = $goals->service_hours_goal * $numMembers;
        $sumTotals['money'] = $goals->service_money_goal * $numMembers;
        $sumTotals['points'] = $goals->points_goal * $numMembers;


        return view('totals.index', compact('averages', 'totals', 'goals', 'sumTotals'));
    }
}
