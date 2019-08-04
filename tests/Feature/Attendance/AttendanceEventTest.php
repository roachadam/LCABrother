<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\AttendanceEvent;

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
        $attendanceEvent = factory(AttendanceEvent::class)->create(['organization_id' => $user->organization_id]);
        // $user->update(['organization_id' => $attendanceEvent->organization_id]);


        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('attendanceEvent.index'))
            ->assertSuccessful()
            ->assertSee('Attendance Records')
            ->assertSee($attendanceEvent->name);
    }
}
