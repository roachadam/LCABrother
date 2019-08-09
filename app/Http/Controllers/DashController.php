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
        $hoursServed = $user->getServiceHours();         //Serivce hours and money donated
        $gpa = $user->latestAcademics()->Current_Term_GPA;
        $points = $user->getInvolvementPoints();


        return view('main.dash', compact('user', 'points', 'moneyDontated', 'hoursServed', 'gpa'));
    }



}
