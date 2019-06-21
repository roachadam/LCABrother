<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use App\CalendarItem;
use App\User;
use App\AttendanceEvent;
use App\Events\AttendanceRecorded;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceEvent $attendanceEvent)
    {
        $attendances = $attendanceEvent->attendance;
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, AttendanceEvent $attendanceEvent)
    {

        return view('attendance.create', compact('attendanceEvent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AttendanceEvent $attendanceEvent)
    {

        //dd($request->all());
        $attributes = $request->validate([
            'users' => 'required'
        ]);
        $involvement = $attendanceEvent->involvement;
        foreach($attributes['users'] as $userID){
            $attendanceEvent->addAttendance([
                'user_id' => $userID
            ]);
            $user = User::find($userID);
            if($involvement !== null){
                $user->addInvolvementLog($involvement, $attendanceEvent->calendarItem->start_date);
            }
        }
        event(new AttendanceRecorded($attendanceEvent));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $involvement = $attendance->attendanceEvent->involvement;
        if($involvement != null){
            $involvementLogs = $involvement->involvementLogs;
            foreach($involvementLogs as $involvementLog){
                if($involvementLog->user_id==$attendance->user_id){
                    // dump('Found attendance log');
                    $involvementLog->delete();
                    break;
                }
            }
        }
        $attendance->delete();
        return back();
    }
}
