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
        $attendanceEvent = factory(AttendanceEvent::class)->create();
        $user->update(['organization_id' => $attendanceEvent->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendance.index', $attendanceEvent))
            ->assertSuccessful()
            ->assertSee($attendanceEvent->name . ' Attendance');
    }


    /**
     * Take attendance page AttendanceController@create
     * Delete a user's attendance record AttendanceController@destroy
     */
}
