<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\AttendanceEvent;
use Tests\TestCase;
use App\Attendance;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * AttendanceController@index
     * Testing basic user can view attendance record breakdown for an event
     */
    public function test_basic_user_can_view_attendance_record_breakdown_for_event()
    {
        $user = $this->loginAs('basic_user');
        $attendanceEvent = $this->arrange($user);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendance.index', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee($attendanceEvent->name . ' Attendance')
            ->assertDontSee('Take Attendance')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceController@index
     * Testing attendance manager can view attendance record breakdown for an event
     */
    public function test_attendance_manager_can_view_attendance_record_breakdown_for_event()
    {
        $user = $this->loginAs('attendance_manager');
        $attendanceEvent = $this->arrange($user);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendance.index', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee($attendanceEvent->name . ' Attendance')
            ->assertSee('Take Attendance')
            ->assertSee('Delete');
    }

    /**
     * * AttendanceController@index
     * Testing attendance taker can view attendance record breakdown for an event
     */
    public function test_attendance_taker_can_view_attendance_record_breakdown_for_event()
    {
        $user = $this->loginAs('attendance_taker');
        $attendanceEvent = $this->arrange($user);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendance.index', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee($attendanceEvent->name . ' Attendance')
            ->assertSee('Take Attendance')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceController@create
     * Testing ability to get the take attendance view
     */
    public function test_get_take_attendance_view()
    {
        $user = $this->loginAs('attendance_taker');
        $attendanceEvent = $this->arrange($user);


        // dd(AttendanceEvent::all()->first()->attendance);

        // $attendanceLog = factory(Attendance::class)->create([
        //     'attendance_event_id' => $attendanceEvent->id,
        //     'user_id' => $user->id,
        // ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('attendance.index', $attendanceEvent))
            ->get(route('attendance.create', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee($user->name);
    }


    /**
     * Helper function that sets up data needed for tests
     */
    private function arrange($user): AttendanceEvent
    {
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);
        return $attendanceEvent;
    }
}
