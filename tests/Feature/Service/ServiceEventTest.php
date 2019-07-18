<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\ServiceEvent;
use Tests\TestCase;
use App\ServiceLog;

class ServiceEventTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * * ServiceEventController@index
     * Testing a basic user's ability to view service event's page
     */
    public function test_basic_user_view_service_events()
    {
        $user = $this->loginAsBasic();
        $serviceEvent = factory(ServiceEvent::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceEvent.index'))
            ->assertSuccessful()
            ->assertSee($serviceEvent->name)
            ->assertSee($serviceEvent->getAttendance())
            ->assertSee($serviceEvent->date_of_event->format('Y-m-d'))
            ->assertDontSee('Manage');
    }

    /**
     * * ServiceEventController@index
     * Testing an admin's ability to view service event's page
     */
    public function test_admin_user_view_service_events()
    {
        $user = $this->loginAsAdmin();
        $serviceEvent = factory(ServiceEvent::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceEvent.index'))
            ->assertSuccessful()
            ->assertSee($serviceEvent->name)
            ->assertSee($serviceEvent->getAttendance())
            ->assertSee($serviceEvent->date_of_event->format('Y-m-d'))
            ->assertSee('Manage');
    }

    /**
     * * ServiceEventController@store
     * Tests adding new Service Events
     */
    public function test_add_new_service_event()
    {
        $user = $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('serviceEvent.store'), [
                'name' => 'Pumpkin Bust',
                'date_of_event' => '2001-10-26',
                'hours_served' => null,
                'money_donated' => '12'
            ])
            ->assertSuccessful()
            ->assertSee('Logged Service Event!')
            ->assertSessionHasNoErrors();


        $this->assertDatabaseHas('service_events', [
            'organization_id' => $user->organization_id,
            'name' => 'Pumpkin Bust',
            'date_of_event' => '2001-10-26',
        ]);

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $user->organization_id,
            'user_id' => auth()->id(),
            'money_donated' => '12',
        ]);
    }

    /**
     * * ServiceEventController@store
     * Testing adding service log with an existing event
     */
    public function test_adding_log_with_existing_event()
    {
        $user = $this->loginAsAdmin();

        $serviceEvent = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
            'name' => 'Pumpkin Bust',
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('serviceEvent.store'), [
                'name' => $serviceEvent->name,
                'date_of_event' => '2001-10-26',
                'money_donated' => '12',
            ])
            ->assertSuccessful()
            ->assertSee('Logged Service Event!')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $user->organization_id,
            'user_id' => auth()->id(),
            'service_event_id' => $serviceEvent->id,
            'money_donated' => '12',
            'hours_served' => null,
        ]);
    }

    /**
     * * ServiceEventController@store
     * Testing adding Service log without money donated
     */
    public function test_adding_log_without_money_donated()
    {
        $user = $this->loginAsAdmin();

        $serviceEvent = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('serviceEvent.store'), [
                'name' => $serviceEvent->name,
                'hours_served' => '1',
                'date_of_event' => '2001-10-26',
            ])
            ->assertSuccessful()
            ->assertSee('Logged Service Event!')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'service_event_id' => $serviceEvent->id,
            'money_donated' => null,
            'hours_served' => 1,
        ]);
    }

    /**
     * * ServiceEventController@store
     * Testing adding log without both money donated and hours served
     */
    public function test_adding_log_without_money_donated_and_hours_served()
    {
        $user = $this->loginAsAdmin();

        $serviceEvent = factory(ServiceEvent::class)->make([
            'organization_id' => $user->organization_id,
        ]);

        $this
            ->post(route('serviceEvent.store'), [
                'name' => $serviceEvent->name,
                'date_of_event' => '2001-10-26',
            ])
            ->assertSessionHasErrors(['money_donated', 'hours_served']);

        $this->assertDatabaseMissing('service_events', [
            'name' => $serviceEvent->name,
            'date_of_event' => '2001-10-26',
        ]);
    }

    /**
     * * ServiceEventController@store
     * Testing adding Service log without a name
     */
    public function test_adding_log_without_name()
    {
        $this->loginAsAdmin();

        $this
            ->post(route('serviceEvent.store'), [
                'name' => '',
                'date_of_event' => '2001-10-26',
                'money_donated' => '12',
            ])
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('service_events', [
            'name' => '',
            'date_of_event' => '2001-10-26',
            'money_donated' => '12',
        ]);
    }

    /**
     * * ServiceEventController@show
     * Testing the ability to delete service events
     */
    public function test_show_service_event()
    {
        $user = $this->loginAsAdmin();

        $serviceEvent = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $serviceLogs = factory(ServiceLog::class, 2)->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'service_event_id' => $serviceEvent
        ]);

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceEvent.index'))
            ->get(route('serviceEvent.show', $serviceEvent));

        $response->assertSuccessful()
            ->assertSee($serviceEvent->name . ' Attendance');

        foreach ($serviceLogs as $serviceLog) {
            $response->assertSee($user->name);
            $response->assertSee($serviceLog->user->name);
            $response->assertSee($serviceLog->created_at);
            $response->assertSee($serviceLog->hours_served);
            $response->assertSee($serviceLog->money_donated);
        }
    }

    /**
     * * ServiceEventController@destroy
     * Testing the ability to delete service events and its corresponding logs
     */
    public function test_delete_service_event()
    {
        $user = $this->loginAsAdmin();

        $serviceEvent = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $serviceLogs = factory(ServiceLog::class, 2)->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'service_event_id' => $serviceEvent
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('serviceEvent.show', $serviceEvent))
            ->delete(route('serviceEvent.destroy', $serviceEvent))
            ->assertSuccessful()
            ->assertSee('Successfully deleted Event and Logs!');

        $this->assertDatabaseMissing('service_events', [
            'id' => $serviceEvent->id,
            'organization_id' => $user->organization_id,
            'name' => $serviceEvent->name,
            'date_of_event' => $serviceEvent->date_of_event,
        ]);

        foreach ($serviceLogs as $serviceLog) {
            $this->assertDatabaseMissing('service_logs', [
                'id' => $serviceLog->id,
                'organization_id' => $user->organization_id,
                'service_event_id' => $serviceEvent->id,
                'user_id' => $user->id,
                'hours_served' => $serviceLog->hours_served,
                'money_donated' => $serviceLog->money_donated,
            ]);
        }
    }
}
