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
        $precision = 3;

        $averages['service'] = $this->number_clean(number_format($averages['service'], $precision, '.', ','));
        $averages['money'] = $this->number_clean(number_format($averages['money'], $precision, '.', ','));
        $averages['points'] = $this->number_clean(number_format($averages['points'], $precision, '.', ','));

        $goals = $organization->goals;
        $numMembers = $organization->getVerifiedMembers()->count();

        $sumTotals['service'] = $goals->service_hours_goal * $numMembers;
        $sumTotals['money'] = $goals->service_money_goal * $numMembers;
        $sumTotals['points'] = $goals->points_goal * $numMembers;


        return view('totals.index', compact('averages', 'totals', 'goals', 'sumTotals'));
    }

    /*
    * Function: number_clean
    * Purpose: Remove trailing and leading zeros - just to return cleaner number
    */
    private function number_clean($num)
    {

        //remove zeros from end of number ie. 140.00000 becomes 140.
        $clean = rtrim($num, '0');
        //remove zeros from front of number ie. 0.33 becomes .33
        // $clean = ltrim($clean, '0');
        //remove decimal point if an integer ie. 140. becomes 140
        $clean = rtrim($clean, '.');

        return $clean;
    }
}
