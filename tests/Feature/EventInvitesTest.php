<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Event;

class EventInvitesTest extends TestCase
{
    Use RefreshDatabase;

    public function test_get_events_index()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/event');

        $response->assertOk();
    }
    public function test_get_create_view(){
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/event/create');

        $response->assertStatus(200);
    }

    public function test_create_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $event = factory(Event::class)->raw(['organization_id' => auth()->user()->organization->id]);
        $response = $this->post('/event', $event);

        $this->assertDatabaseHas('events',[
            'organization_id' => auth()->user()->organization->id,
            'name' => $event['name'],
            'date_of_event' => $event['date_of_event'],
            'num_invites' => $event['num_invites'],
        ]);

        $response->assertStatus(302);
    }
}
