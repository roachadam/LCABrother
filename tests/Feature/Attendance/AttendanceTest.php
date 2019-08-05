<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\AttendanceEvent;
use Tests\TestCase;

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
     * Helper function that sets up data needed for tests
     */
    private function arrange($user): AttendanceEvent
    {
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);
        return $attendanceEvent;
    }
}
