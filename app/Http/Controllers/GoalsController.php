<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goals;
use App\Organization;

class GoalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageGoals');
    }

    public function index()
    {
        $goals = auth()->user()->organization->goals;
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        //validate
        $attributes = request()->validate([
            'points_goal' => ['required', 'numeric', 'min:0', 'max:10000'],
            'service_hours_goal' => ['required', 'numeric', 'min:0', 'max:999'],
            'service_money_goal' => ['required', 'numeric', 'min:0', 'max:999'],
            'study_goal' => ['required', 'numeric', 'min:0', 'max:999'],
        ]);

        //persist
        $org = auth()->user()->organization;
        $org->setGoals($attributes);

        //redirect
        return view('semester.create');
    }

    public function edit()
    {
        $goals = auth()->user()->organization->goals;
        return view('goals.edit', compact('goals'));
    }

    public function update(Goals $goals)
    {
        $attributes = request()->validate([
            'points_goal' => ['required', 'numeric', 'min:0', 'max:10000'],
            'service_hours_goal' => ['required', 'numeric', 'min:0', 'max:999'],
            'service_money_goal' => ['required', 'numeric', 'min:0', 'max:999'],
            'study_goal' => ['required', 'numeric', 'min:0', 'max:999'],
        ]);

        $goals->update($attributes);

        return redirect('/goals/');
    }
}
