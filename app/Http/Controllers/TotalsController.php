<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TotalsController extends Controller
{


    public function index()
    {
        $totals = auth()->user()->organization->getTotals();
        $averages = auth()->user()->organization->getAverages();
        $goals = auth()->user()->organization->goals;

        $numMembers = auth()->user()->organization->users()->count();
        $sumTotals['service'] = $goals->service_hours_goal * $numMembers;
        $sumTotals['money'] = $goals->service_money_goal* $numMembers;
        $sumTotals['points'] = $goals->points_goal* $numMembers;
        return view('totals.index')->with('averages',$averages)->with('totals', $totals)->with('sumTotals', $sumTotals);
    }




}
