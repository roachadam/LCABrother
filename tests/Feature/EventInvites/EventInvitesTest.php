<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Event;
use App\Invite;
use App\User;
use App\Organization;
use Illuminate\Auth\Access\Response;
use DB;

class EventInvitesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_events_index()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/event');

        $response->assertOk();
    }
    public function test_get_create_view()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/event/create');

        $response->assertStatus(200);
    }
    public function test_get_edit_view()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $response = $this->get('/event/' . $event->id);

        $response->assertStatus(200);
    }

    public function test_create_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $event = factory(Event::class)->raw(['organization_id' => auth()->user()->organization->id]);
        $response = $this->post('/event', $event);

        $this->assertDatabaseHas('events', [
            'organization_id' => auth()->user()->organization->id,
            'name' => $event['name'],
            'date_of_event' => $event['date_of_event'],
            'num_invites' => $event['num_invites'],
        ]);

        $response->assertStatus(302);
    }

    public function test_edit_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $newName = 'NewEventName';
        $response = $this->patch('event/' . $event->id, [
            'name' => $newName
        ]);

        $this->assertDatabaseHas('events', [
            'organization_id' => auth()->user()->organization->id,
            'name' => $newName,
            'date_of_event' => $event->date_of_event,
            'num_invites' => $event->num_invites,
        ]);

        $this->assertDatabaseMissing('events', [
            'organization_id' => auth()->user()->organization->id,
            'name' => $event->name,
            'date_of_event' => $event->date_of_event,
            'num_invites' => $event->num_invites,
        ]);
    }

    public function test_get_user_guest_list()
    {
        //$this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $user2 = factory(User::class)->create(['organization_id' => auth()->user()->organization->id]);

        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $inviteAttributes1 = factory(Invite::class)->raw(['user_id' => auth()->id()]);
        $event->addInvite($inviteAttributes1);
        $inviteAttributes2 = factory(Invite::class)->raw(['user_id' => auth()->id()]);
        $event->addInvite($inviteAttributes2);
        $inviteAttributes3 = factory(Invite::class)->raw(['user_id' => $user2->id]);
        $event->addInvite($inviteAttributes3);

        $response = $this->get('event/' . $event->id . '/invites');

        $response->assertSee($inviteAttributes1['guest_name']);
        $response->assertSee($inviteAttributes2['guest_name']);
        //$response->assertDontSee($inviteAttributes3['guest_name']);
    }
    public function test_get_entire_guest_list()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $user2 = factory(User::class)->create(['organization_id' => auth()->user()->organization->id]);

        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $inviteAttributes1 = factory(Invite::class)->raw(['user_id' => auth()->id()]);
        $event->addInvite($inviteAttributes1);
        $inviteAttributes2 = factory(Invite::class)->raw(['user_id' => auth()->id()]);
        $event->addInvite($inviteAttributes2);
        $inviteAttributes2 = factory(Invite::class)->raw(['user_id' => auth()->id()]);
        $event->addInvite($inviteAttributes2);
        $inviteAttributes3 = factory(Invite::class)->raw(['user_id' => $user2->id]);
        $event->addInvite($inviteAttributes3);

        $response = $this->get('event/' . $event->id . '');

        $response->assertSee($inviteAttributes1['guest_name']);
        $response->assertSee($inviteAttributes2['guest_name']);
        $response->assertSee($inviteAttributes3['guest_name']);
    }
    public function test_delete_invite()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $invite = factory(Invite::class)->create(['user_id' => auth()->id()]);
        $inviteArray = $invite->toArray();
        $response = $this->delete('invite/' . $invite->id);
        $this->assertDatabaseMissing('invites', $inviteArray);
    }
    public function test_cannot_insert_duplicates()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $invite = factory(Invite::class)->raw([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        $response = $this->post('event/' . $event->id . '/invite', $invite);
        $response = $this->post('event/' . $event->id . '/invite', $invite);
        $response->assertSessionHas('error', $invite['guest_name'] . ' has already been invited.');
    }
    public function test_delete_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);

        $response = $this->delete('event/' . $event->id);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id
        ]);
        $response->assertRedirect('/events');
    }
    public function test_not_admin_cant_delete_event()
    {
        $this->withoutExceptionHandling();
        $organization = factory(Organization::class)->create();
        $this->loginAsAdmin($organization);
        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        auth()->logout();

        $this->loginAsBasic($organization);
        $response = $this->delete('event/' . $event->id);

        $this->assertDatabaseHas('events', [
            'id' => $event->id
        ]);
    }
}
