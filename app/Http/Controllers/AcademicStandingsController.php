<?php

namespace App\Http\Controllers;

use App\AcademicStandings;
use Illuminate\Http\Request;

class AcademicStandingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('orgverified');
        $this->middleware('ManageAcademics');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicStandings = auth()->user()->organization->academicStandings;
        return view('academics.academicStandings.index', compact('academicStandings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academicStandings = auth()->user()->organization->academicStandings;
        return view('academics.academicStandings.create', compact('academicStandings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'alpha', 'unique:academic_standings,organization_id'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0', 'unique:academic_standings'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'SubmitAndFinishCheck' => ['required', 'boolean'],
        ]);

        $SubmitAndFinishCheck = $attributes['SubmitAndFinishCheck'];
        unset($attributes['SubmitAndFinishCheck']);

        Auth()->user()->organization->addAcademicStandings($attributes);

        return ($SubmitAndFinishCheck) ? redirect('/forum/create/categories') : back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AcademicStandings  $academicStandings
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicStandings $academicStandings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AcademicStandings  $academicStandings
     * @return \Illuminate\Http\Response
     */
    public function edit($academicStandingId)
    {
        $match = [
            'id' => $academicStandingId,
            'organization_id' => auth()->user()->organization->id
        ];

        $academicStanding = AcademicStandings::where('id', $academicStandingId)->get()->first();
        return view('academics.academicStandings.override', compact('academicStanding'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AcademicStandings  $academicStandings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicStandings $academicStandings)
    {
        $attributes = $request->validate([
            'name' => ['required', 'alpha'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
        ]);
        $academicStandings->update($attributes);

        $users = auth()->user()->organization->users;

        foreach ($users as $user) {
            $user->checkAcademicRecords();
        }

        return redirect('/academicStandings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AcademicStandings  $academicStandings
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicStandings $academicStandings)
    {
        //
    }
}
