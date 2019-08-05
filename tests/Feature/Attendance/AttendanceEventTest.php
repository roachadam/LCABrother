<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\AttendanceEvent;
use Tests\TestCase;

class AttendanceEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * AttendanceEventController@index
     * Testing ability of basic users to view the attendance events page
     */
    public function test_basic_user_can_get_attendance_events_page()
    {
        $user = $this->loginAs('basic_user');
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendanceEvents.index'))
            ->assertSuccessful()
            ->assertSee('Attendance Records')
            ->assertSee($attendanceEvent->name)
            ->assertDontSee('Take Attendance')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceEventController@index
     * Testing ability of attendance manager to view the attendance events page
     */
    public function test_attendance_manager_can_get_attendance_events_page()
    {
        $user = $this->loginAs('attendance_manager');
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendanceEvents.index'))
            ->assertSuccessful()
            ->assertSee('Attendance Records')
            ->assertSee($attendanceEvent->name)
            ->assertSee('Take Attendance')
            ->assertSee('Delete');
    }

    /**
     * * AttendanceEventController@index
     * Testing ability of events manager to view the attendance events page
     */
    public function test_attendance_taker_can_get_attendance_events_page()
    {
        $user = $this->loginAs('attendance_taker');
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendanceEvents.index'))
            ->assertSuccessful()
            ->assertSee('Attendance Records')
            ->assertSee($attendanceEvent->name)
            ->assertSee('Take Attendance')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceController@destroy
     * Testing ability of events manager to delete the attendance event
     */
    public function test_events_manager_can_delete_attendance_event()
    {
        $user = $this->loginAs('attendance_manager');
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('attendanceEvents.index'))
            ->delete(route('attendanceEvents.destroy', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee('Event Deleted!');
    }
}
