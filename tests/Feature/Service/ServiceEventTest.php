<?php

namespace Tests\Feature;

use DB;
use App\ServiceEvent;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing a basic user's ability to view service event's page
     */
    public function test_serviceEvents_basic_view()
    {
        $user = $this->loginAsBasic();
        $event = factory(ServiceEvent::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceEvent.index'))
            ->assertSuccessful()
            ->assertSee($event->name)
            ->assertSee($event->date_of_event->format('Y-m-d'))
            ->assertDontSee('Manage');
    }

    /**
     * Testing an admin's ability to view service event's page
     */
    public function test_serviceEvents_admin_view()
    {
        $user = $this->loginAsAdmin();
        $event = factory(ServiceEvent::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('serviceEvent.index'))
            ->assertSuccessful()
            ->assertSee($event->name)
            ->assertSee($event->date_of_event->format('Y-m-d'))
            ->assertSee('Manage');
    }

    /**
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
     * Testing adding service log with an existing event
     */
    public function test_adding_log_with_existing_event()
    {
        $user = $this->loginAsAdmin();

        $event = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
            'name' => 'Pumpkin Bust',
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('serviceEvent.store'), [
                'name' => $event->name,
                'date_of_event' => '2001-10-26',
                'money_donated' => '12',
            ])
            ->assertSuccessful()
            ->assertSee('Logged Service Event!')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $user->organization_id,
            'user_id' => auth()->id(),
            'service_event_id' => $event->id,
            'money_donated' => '12',
            'hours_served' => null,
        ]);
    }

    /**
     * Testing adding Service log without money donated
     */
    public function test_adding_log_without_money_donated()
    {
        $user = $this->loginAsAdmin();

        $event = factory(ServiceEvent::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('serviceEvent.store'), [
                'name' => $event->name,
                'hours_served' => '1',
                'date_of_event' => '2001-10-26',
            ])
            ->assertSuccessful()
            ->assertSee('Logged Service Event!')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'service_event_id' => $event->id,
            'money_donated' => null,
            'hours_served' => 1,
        ]);
    }

    /**
     * Testing adding log without both money donated and hours served
     */
    public function test_adding_log_without_money_donated_and_hours_served()
    {
        $user = $this->loginAsAdmin();

        $event = factory(ServiceEvent::class)->make([
            'organization_id' => $user->organization_id,
        ]);

        $this
            ->post(route('serviceEvent.store'), [
                'name' => $event->name,
                'date_of_event' => '2001-10-26',
            ])
            ->assertSessionHasErrors(['money_donated', 'hours_served']);

        $this->assertDatabaseMissing('service_events', [
            'name' => $event->name,
            'date_of_event' => '2001-10-26',
        ]);
    }

    /**
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
}
