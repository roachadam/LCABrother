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
        $academicStandings = AcademicStandings::where('organization_id', auth()->user()->organization->id)->get()->sortByDesc('Term_GPA_Min');
        return view('academics.academicStandings.index', compact('academicStandings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academicStandings = AcademicStandings::where('organization_id', auth()->user()->organization->id)->get()->sortByDesc('Term_GPA_Min');
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
            'name' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/', 'unique:academic_standings,organization_id'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0', 'unique:academic_standings'],
            'SubmitAndFinishCheck' => ['required', 'boolean'],
        ]);

        $attributes['nameWithSpace'] = $attributes['name'];
        $attributes['name'] = str_replace(' ', '_', $attributes['name']);

        $SubmitAndFinishCheck = $attributes['SubmitAndFinishCheck'];
        unset($attributes['SubmitAndFinishCheck']);

        Auth()->user()->organization->addAcademicStandings($attributes);

        return ($SubmitAndFinishCheck) ? redirect('/forum/create/categories') : back();
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
        return view('academics.academicStandings.edit', compact('academicStanding'));
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
            'name' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
        ]);

        $academicStandings->update($attributes);
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
        $academicStandings->delete();
        return back();
    }
}
