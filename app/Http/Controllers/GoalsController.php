<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goals;
use App\Organization;
class GoalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ManageInvolvement');
    }

    public function create(){
        return view('goals.create');
    }

    public function store(Request $request)
    {
        //validate
        $attributes = request()->validate([
             'points_goal' => 'required',
             'service_hours_goal' => 'required',
             'service_money_goal' => 'required',
             'study_goal' => 'required',
         ]);

        //persist
        $org = auth()->user()->organization;
        $org->setGoals($attributes);

        //redirect
        return redirect('/role');

    }
}
