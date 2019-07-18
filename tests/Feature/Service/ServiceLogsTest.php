<?php

namespace Tests\Feature;

use DB;
use App\ServiceLog;
use Tests\TestCase;
use App\ServiceEvent;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class ServiceLogsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * ServiceEventController@index
     * Testing basic user's ability to view service logs page
     */
    public function test_basic_user_view_service_logs()
    {
        $user = $this->loginAsBasic();

        $attributes = $this->arrange($user, 10);
        $serviceLogs = $attributes['serviceLog'];

        $totalHours = $serviceLogs->sum('hours_served');
        $totalMoney = $serviceLogs->sum('money_donated');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceLogs.index'))
            ->assertSuccessful()
            ->assertSee($user->name)
            ->assertSee($totalHours)
            ->assertSee($totalMoney)
            ->assertDontSee('View');
    }


    /**
     * * ServiceEventController@index
     * Testing admin's ability to view service logs page
     */
    public function test_admin_view_service_logs()
    {
        $user = $this->loginAsAdmin();

        $attributes = $this->arrange($user, 10);
        $serviceLogs = $attributes['serviceLog'];

        $totalHours = $serviceLogs->sum('hours_served');
        $totalMoney = $serviceLogs->sum('money_donated');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceLogs.index'))
            ->assertSuccessful()
            ->assertSee($user->name)
            ->assertSee($totalHours)
            ->assertSee($totalMoney)
            ->assertSee('View');
    }

    /**
     * * ServiceEventController@edit
     * Testing viewing edit service log page
     */
    public function test_view_edit_service_log()
    {
        $user = $this->loginAsAdmin();

        $attributes = $this->arrange($user);
        $serviceLog = $attributes['serviceLog'];

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceLogs.breakdown', $user))
            ->get(route('serviceLogs.edit', $serviceLog))
            ->assertSuccessful()
            ->assertSee($serviceLog->serviceEvent->name . ' Log Edit')
            ->assertSee($serviceLog->hours_served)
            ->assertSee($serviceLog->money_donated);
    }

    /**
     * * ServiceEventController@update
     * Testing ability to edit and update a service log
     */
    public function test_update_service_log()
    {
        $user = $this->loginAsAdmin();

        $attributes = $this->arrange($user);
        $serviceLog = $attributes['serviceLog'];

        $createdHours = $serviceLog->hours_served;
        $createdMoney = $serviceLog->money_donated;

        $updatedHours = $serviceLog->hours_served + 1;
        $updatedMoney = $serviceLog->money_donated + 1;

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceLogs.edit', $serviceLog))
            ->patch(route('serviceLogs.update', $serviceLog), [
                'hours_served' => $updatedHours,
                'money_donated' => $updatedMoney,
            ])
            ->assertSuccessful();

        $storedServiceLog = $user->serviceLogs->where('id', $serviceLog->id)->first();

        $this->assertNotEquals($createdHours, $storedServiceLog->hours_served);
        $this->assertNotEquals($createdMoney, $storedServiceLog->money_donated);

        $this->assertEquals($updatedHours, $storedServiceLog->hours_served);
        $this->assertEquals($updatedMoney, $storedServiceLog->money_donated);

        $this->assertDatabaseHas('service_logs', [
            'id' => $serviceLog->id,
            'organization_id' => $user->organization_id,
            'service_event_id' => $attributes['serviceEvent']->id,
            'user_id' => $user->id,
            'hours_served' => $updatedHours,
            'money_donated' => $updatedMoney,
        ]);
    }

    /**
     * * ServiceEventController@breakdown
     * Testing ability to get the user's service breakdown
     */
    public function test_view_user_service_breakdown()
    {
        $user = $this->loginAsAdmin();

        $attributes = $this->arrange($user);
        $serviceLog = $attributes['serviceLog'];

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceEvent.index'))
            ->get(route('serviceLogs.breakdown', $user->id))
            ->assertSuccessful()
            ->assertSee($user->name)
            ->assertSee($serviceLog->serviceEvent->name)
            ->assertSee($serviceLog->hours_served)
            ->assertSee($serviceLog->money_donated);
    }

    /**
     * * ServiceEventController@destroy
     * Testing ability to delete the user's service log
     */
    public function test_delete_service_log()
    {
        $user = $this->loginAsAdmin();

        $attributes = $this->arrange($user);
        $serviceLog = $attributes['serviceLog'];

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceLogs.edit', $serviceLog))
            ->delete(route('serviceLogs.destroy', $serviceLog))
            ->assertSuccessful()
            ->assertSee('Successfully deleted Service Log!');

        $this->assertDatabaseMissing('service_logs', [
            'id' => $serviceLog->id,
            'organization_id' => $user->organization_id,
            'service_event_id' => $attributes['serviceEvent']->id,
            'user_id' => $user->id,
            'hours_served' => $serviceLog->hours_served,
            'money_donated' => $serviceLog->money_donated,
        ]);
    }

    /**
     * Helper method that seeds the database with data needed for tests
     */
    private function arrange($user, $numOfLogs = null): array
    {
        $logsIsset = isset($numOfLogs);
        $serviceEvent = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $serviceLogs = factory(ServiceLog::class, $logsIsset ? $numOfLogs : 1)->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'service_event_id' => $serviceEvent
        ]);

        return [
            'user' => $user,
            'serviceEvent' => $serviceEvent,
            'serviceLog' => $logsIsset ? $serviceLogs : $serviceLogs->first(),
        ];
    }
}
