<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\AttendanceEvent;

class AttendanceEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageEvents')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $attendanceEvents = $user->organization->attendanceEvent;

        return view('attendanceEvents.index', compact('attendanceEvents', 'user'));
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

        NotificationFunctions::alert('success', 'Event Deleted!');
        return back();
    }
}
