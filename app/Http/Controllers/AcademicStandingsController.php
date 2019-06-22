<?php

namespace App\Http\Controllers;

use App\AcademicStandings;
use Illuminate\Http\Request;

class AcademicStandingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'name' => 'required',             //TODO validate unique to organization
            'Cumulative_GPA_Min' => ['required', 'numeric'],
            'Term_GPA_Min' => ['required', 'numeric']
        ]);

        Auth()->user()->organization->addAcademicStandings($attributes);

        return back();
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
    public function edit(AcademicStandings $academicStandings)
    {
        //
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
        //
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