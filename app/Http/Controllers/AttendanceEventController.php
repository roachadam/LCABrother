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
        return back();
    }
}
