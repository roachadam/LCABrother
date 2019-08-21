<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\AcademicStandings;

class AcademicStandingsController extends Controller
{
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
    // public function create()
    // {
    //     $academicStandings = AcademicStandings::where('organization_id', auth()->user()->organization->id)->get()->sortByDesc('Term_GPA_Min');
    //     return view('academics.academicStandings.create', compact('academicStandings'));
    // }

    /**
     * Store a newly created resource in storage.
     *  ! Commented out code is for having the set initial academic standings rules paged when creating a new organization
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'unique:academic_standings,organization_id'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0', 'unique:academic_standings'],
            //'SubmitAndFinishCheck' => ['required', 'boolean'],
        ]);

        //$SubmitAndFinishCheck = $attributes['SubmitAndFinishCheck'];
        //unset($attributes['SubmitAndFinishCheck']);

        Auth()->user()->organization->addAcademicStandings($attributes);

        NotificationFunctions::alert('success', 'Successfully Created New Rule!');

        return /* ($SubmitAndFinishCheck) ? redirect('/forum/create/categories') : */ back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AcademicStandings  $academicStandings
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicStandings $academicStandings)
    {
        return view('academics.academicStandings.edit', ['academicStanding' => $academicStandings]);
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
            'name' => ['required'],
            'Cumulative_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
            'Term_GPA_Min' => ['required', 'numeric', 'between:0,4.0'],
        ]);

        $academicStandings->update($attributes);

        NotificationFunctions::alert('success', 'Successfully Updated Standing Rule!');
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
        NotificationFunctions::alert('success', 'Successfully Deleted Standing Rule!');
        return back();
    }
}
