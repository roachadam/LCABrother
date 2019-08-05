<?php

namespace App\Http\Controllers;

use App\Events\FailedToRecordAttendance;
use App\Commons\NotificationFunctions;
use App\Events\AttendanceRecorded;
use Illuminate\Http\Request;
use App\AttendanceEvent;
use App\Attendance;
use App\User;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('TakeAttendance')->only(['create', 'store']);
        $this->middleware('ManageAttendance')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceEvent $attendanceEvent)
    {
        $user = auth()->user();
        $attendances = $attendanceEvent->attendance;
        return view('attendance.index', compact('user', 'attendances', 'attendanceEvent'));
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
        $attributes = $request->validate([
            'users' => 'required'
        ]);
        $involvement = $attendanceEvent->involvement;
        $usersNotInAttendance = $attendanceEvent->getUsersNotInAttendance();
        $notAllFailed = false;
        foreach ($attributes['users'] as $userID) {
            $user = User::find($userID);
            if ($usersNotInAttendance->contains('id', $user->id)) {
                $attendanceEvent->addAttendance([
                    'user_id' => $user->id
                ]);
                if ($involvement !== null) {
                    $user->addInvolvementLog($involvement, $attendanceEvent->calendarItem->start_date);
                }
                $notAllFailed = true;
            } else {
                event(new FailedToRecordAttendance($user));
            }
        }
        if ($notAllFailed) {
            event(new AttendanceRecorded($attendanceEvent));
        }

        return back();
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
        if ($involvement != null) {
            $involvementLogs = $involvement->involvementLogs;
            foreach ($involvementLogs as $involvementLog) {
                if ($involvementLog->user_id == $attendance->user_id) {
                    $involvementLog->delete();
                    break;
                }
            }
        }
        $attendance->delete();

        NotificationFunctions::alert('success', 'Attendance log(s) deleted!');
        return back();
    }
}
