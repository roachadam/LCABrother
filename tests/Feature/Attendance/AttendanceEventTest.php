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
            ->assertDontSee('Create New Event')
            ->assertDontSee('Take Attendance')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceEventController@index
     * Testing ability of attendance manager to view the attendance events page
     */
    public function test_attendance_manager_can_get_attendance_events_page()
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
            ->assertDontSee('Create New Event')
            ->assertDontSee('Delete');
    }

    /**
     * * AttendanceEventController@index
     * Testing ability of events manager to view the attendance events page
     */
    public function test_events_manager_can_get_attendance_events_page()
    {
        $user = $this->loginAs('events_manager');
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendanceEvents.index'))
            ->assertSuccessful()
            ->assertSee('Attendance Records')
            ->assertSee($attendanceEvent->name)
            ->assertSee('Create New Event')
            ->assertSee('Delete')
            ->assertDontSee('Take Attendance');
    }

    /**
     * * AttendanceController@destroy
     * Testing ability of events manager to delete the attendance event
     */
    public function test_events_manager_can_delete_attendance_event()
    {
        $user = $this->loginAs('events_manager');
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
