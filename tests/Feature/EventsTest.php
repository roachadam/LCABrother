<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Invite;
use App\Event;
use App\User;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * EventsController@index
     * Testing ability of basic user to view the events page
     */
    public function test_basic_user_can_view_events_index()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('event.index'))
            ->assertSuccessful()
            ->assertSee('Events')
            ->assertDontSee('Add Event');
    }

    /**
     * * EventsController@index
     * Testing ability of the event manager to view the events page
     */
    public function test_event_manager_can_view_events_index()
    {
        $this->loginAs('events_manager');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('event.index'))
            ->assertSuccessful()
            ->assertSee('Events')
            ->assertSee('Add Event');
    }

    /**
     * * EventsController@store
     * Testing ability to create an Event with valid data
     */
    public function test_can_create_event_with_valid_data()
    {
        $user = $this->loginAs('events_manager');
        $event = factory(Event::class)->raw(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->post('/event', $event)
            ->assertSuccessful()
            ->assertSee('Successfully created new Event!')
            ->assertSee($event['name'])
            ->assertSee($event['num_invites']);

        $this->assertDatabaseHas('events', [
            'organization_id' => $user->organization_id,
            'name' => $event['name'],
            'date_of_event' => $event['date_of_event'],
            'num_invites' => $event['num_invites'],
        ]);
    }

    /**
     * * EventsController@show
     * Testing ability to create an Event with valid data
     */
    public function test_get_entire_guest_list()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('events_manager');
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

    /**
     * * EventsController@edit
     * Testing ability to create an Event with valid data
     */
    public function test_get_edit_view()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('events_manager');
        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);
        $response = $this->get('/event/' . $event->id);

        $response->assertStatus(200);
    }

    /**
     * * EventsController@update
     * Testing ability to create an Event with valid data
     */
    public function test_edit_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('events_manager');

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

    /**
     * * EventsController@destroy
     * Testing ability to create an Event with valid data
     */
    public function test_delete_event()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('events_manager');
        $event = factory(Event::class)->create(['organization_id' => auth()->user()->organization->id]);

        $response = $this->delete('event/' . $event->id);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id
        ]);
    }

    /**
     * * EventsController@destroy
     * Testing ability to create an Event with valid data
     */
    public function test_not_events_manager_cant_delete_event()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAs('basic_user');
        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);
        auth()->logout();

        $this->loginAs('basic_user', $user->organization);
        $response = $this->delete('event/' . $event->id);

        $this->assertDatabaseHas('events', [
            'id' => $event->id
        ]);
    }
}
