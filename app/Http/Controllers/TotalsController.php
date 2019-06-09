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
        $chart = new ServiceHoursChart;
        $org = auth()->user()->organization;
        $users = $org->users;
        $serviceHoursArray = $org->getArrayOfServiceHours();

        $chart->labels([1,2,3]);

        $chart->dataset('Hours', 'line', [1,2,3,4]);


        $totals = auth()->user()->organization->getTotals();
        $averages = auth()->user()->organization->getAverages();
        $goals = auth()->user()->organization->goals;

        $numMembers = auth()->user()->organization->users()->count();
        $sumTotals['service'] = $goals->service_hours_goal * $numMembers;
        $sumTotals['money'] = $goals->service_money_goal* $numMembers;
        $sumTotals['points'] = $goals->points_goal* $numMembers;
        return view('totals.index', compact('chart'))->with('averages',$averages)->with('totals', $totals)->with('sumTotals', $sumTotals);
    }




}
