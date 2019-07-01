<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ServiceHoursChart;
class TotalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('orgverified');
    }

    public function index()
    {
        $org = auth()->user()->organization;
        $users = $org->getVerifiedMembers();
        $serviceHoursArray = $org->getArrayOfServiceHours();


        $totals = auth()->user()->organization->getTotals();
        $averages = auth()->user()->organization->getAverages();
        $goals = auth()->user()->organization->goals;

        $numMembers = auth()->user()->organization->getVerifiedMembers()->count();
        $sumTotals['service'] = $goals->service_hours_goal * $numMembers;
        $sumTotals['money'] = $goals->service_money_goal* $numMembers;
        $sumTotals['points'] = $goals->points_goal* $numMembers;


        return view('totals.index', compact('averages', 'totals', 'goals', 'sumTotals'));
    }




}
