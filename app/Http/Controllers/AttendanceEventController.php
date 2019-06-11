<?php

namespace App\Http\Controllers;

use App\AttendanceEvent;
use App\CalendarItem;
use Illuminate\Http\Request;

class AttendanceEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendanceEvents = auth()->user()->organization->attendanceEvent;

        return view('attendanceEvents.index', compact('attendanceEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttendanceEvent  $attendanceEvent
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceEvent $attendanceEvent)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AttendanceEvent  $attendanceEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceEvent $attendanceEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttendanceEvent  $attendanceEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceEvent $attendanceEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttendanceEvent  $attendanceEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceEvent $attendanceEvent)
    {
        $attendanceEvent->delete();
        return back();
    }
}
