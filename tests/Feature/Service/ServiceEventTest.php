<?php

namespace Tests\Feature;

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
        $this->post('/serviceEvent',[
            "_token" => "3yLCtN2XVgs7XNUEyASJIDekJmK9FS4HkbpFXemj",
            "name" => "Pumpkin Bust",
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => "12",
            "hours_served" => null
        ]);

        $this->assertDatabaseHas('service_events',[
            'name' => 'Pumpkin Bust',
            'organization_id' => auth()->user()->organization->id,
            "date_of_event" => "2001-10-26 21:32:52",
        ]);

        $this->assertDatabaseHas('service_logs',[
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            "money_donated" => "12",
        ]);
    }

    public function test_Log_With_Existing_Event(){
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = $org->serviceEvents()->create(
            factory(ServiceEvent::class)->raw()
        );

        $this->post('/serviceEvent',[
            "service_event_id" => $event->id,
            "name" => null,
            "date_of_event" => "2001-10-26 21:32:52",
            "money_donated" => "12",
            "hours_served" => null
        ]);

        $this->assertDatabaseHas('service_logs',[
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'service_event_id' => $event->id,
            "money_donated" => "12",
        ]);

    }
    public function test_view_serviceEvents_table(){
        $this->loginAsAdmin();

        $org = auth()->user()->organization;
        $event = $org->serviceEvents()->create(
            factory(ServiceEvent::class)->raw()
        );

        $this->get('/serviceEvent')
        ->assertSee($event->name);

    }
}
