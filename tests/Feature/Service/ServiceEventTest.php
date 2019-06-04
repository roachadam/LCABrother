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
    public function test_Add_New_Service_Event()
    {
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $this->post('/serviceEvent', [
            "_token" => "3yLCtN2XVgs7XNUEyASJIDekJmK9FS4HkbpFXemj",
            "name" => "Pumpkin Bust",
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => "12",
            "hours_served" => null
        ]);

        $this->assertDatabaseHas('service_events', [
            'name' => 'Pumpkin Bust',
            'organization_id' => auth()->user()->organization->id,
            "date_of_event" => "2001-10-26 21:32:52",
        ]);

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            "money_donated" => "12",
        ]);
    }

    public function test_Log_With_Existing_Event()
    {
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = $org->serviceEvents()->create(
            factory(ServiceEvent::class)->raw()
        );

        $this->post('/serviceEvent', [
            "service_event_id" => $event->id,
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => "12",
        ]);

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $event->id,
            "money_donated" => "12",
        ]);
    }
    public function test_view_serviceEvents_table()
    {
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = $org->serviceEvents()->create(
             factory(ServiceEvent::class)->raw()
        );

        $this->get('/serviceEvent')
        ->assertSee($event->name);
    }

    /** @test **/
    public function create_without_new_name()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = $org->serviceEvents()->create(
            factory(ServiceEvent::class)->raw()
        );

        $response = $this->post('/serviceEvent', [
            "service_event_id" => $event->id,
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => "12",
            "hours_served" => "2"

        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $event->id,
            "money_donated" => "12",
            "hours_served" => "2"
        ]);
    }

    /** @test **/
    public function create_without_old_id()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = factory(ServiceEvent::class)->raw(['organization_id' => $org->id]);


        $response = $this->post('/serviceEvent', [
            "name" => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => 12,
            "hours_served" => 2

        ]);
        $response->assertSessionHasNoErrors();
        $eventDB =  DB::table('service_events')->where('name', $event['name'])->first();
        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $eventDB->id,
            "money_donated" => 12,
            "hours_served" => 2
        ]);
        $this->assertDatabaseHas('service_events', [
            'organization_id' => $org->id,
            'name' => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
        ]);
    }

    /** @test **/
    public function create_without_money_donated()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = factory(ServiceEvent::class)->raw(['organization_id' => $org->id]);


        $response = $this->post('/serviceEvent', [
            "name" => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
            "hours_served" => 2

        ]);
        $response->assertSessionHasNoErrors();
        $eventDB =  DB::table('service_events')->where('name', $event['name'])->first();
        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $eventDB->id,
            "hours_served" => 2
        ]);
        $this->assertDatabaseHas('service_events', [
            'organization_id' => $org->id,
            'name' => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
        ]);
    }

    /** @test **/
    public function create_without_hours_served()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = factory(ServiceEvent::class)->raw(['organization_id' => $org->id]);


        $response = $this->post('/serviceEvent', [
            "name" => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => 15

        ]);
        $response->assertSessionHasNoErrors();
        $eventDB =  DB::table('service_events')->where('name', $event['name'])->first();
        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $eventDB->id,
            "money_donated" => 15
        ]);
        $this->assertDatabaseHas('service_events', [
            'organization_id' => $org->id,
            'name' => $event['name'],
            "date_of_event" => "2001-10-26 21:32:52",
        ]);
    }

    /** @test **/
    public function create_with_both_id_and_name()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = factory(ServiceEvent::class)->create(['organization_id' => $org->id]);


        $response = $this->post('/serviceEvent', [
            "service_event_id" => $event->id,
            "name" => $event->name,
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => 12,
            "hours_served" => 2

        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('service_logs', [
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $event->id,
            "money_donated" => 12,
            "hours_served" => 2
        ]);

        $this->assertDatabaseHas('service_events', [
            'organization_id' => $org->id,
            'name' => $event->name,
            "date_of_event" => $event->date_of_event,
        ]);
        $this->assertDatabaseMissing('service_events', [
            'id' => $event->id +1,
            'organization_id' => $org->id,
            'name' => $event->name,
            "date_of_event" => $event->date_of_event,
        ]);
    }

}
