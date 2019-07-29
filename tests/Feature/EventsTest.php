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
     * Testing ability to view guest list for an event
     */
    public function test_view_event_guest_list()
    {
        $user = $this->loginAs('events_manager');
        $user2 = factory(User::class)->create(['organization_id' => $user->organization_id]);

        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);

        $event->addInvite(factory(Invite::class)->raw(['user_id' => $user->id]));
        $event->addInvite(factory(Invite::class)->raw(['user_id' => $user->id]));
        $event->addInvite(factory(Invite::class)->raw(['user_id' => $user2->id]));
        $event->addInvite(factory(Invite::class)->raw(['user_id' => $user2->id]));

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->get(route('event.show', $event))
            ->assertSuccessful()
            ->assertSee('Guest List')
            ->assertSee($event->name . ' Details')
            ->assertSee('Invites per member: ' . $event->num_invites)
            ->assertSee('Total invites logged: ' . $event->invites->count());

        foreach ($event->invites as $invite) {
            $response->assertSee($invite->name);
        }
    }

    /**
     * * EventsController@edit
     * Testing ability see the edit view
     */
    public function test_get_edit_view()
    {
        $user = $this->loginAs('events_manager');
        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.show', $event))
            ->get(route('event.edit', $event))
            ->assertSuccessful()
            ->assertSee('Edit Event')
            ->assertSee($event->name)
            ->assertSee($event->num_invites);
    }

    /**
     * * EventsController@update
     * Testing ability to update and event's data
     */
    public function test_update_event()
    {
        $user = $this->loginAs('events_manager');

        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);
        $newName = 'NewEventName';
        $newInvites = $event->num_invites + 1;

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.edit', $event))
            ->patch(route('event.update', $event), [
                'name' => $newName,
                'num_invites' => $newInvites
            ])
            ->assertSuccessful()
            ->assertSee('Successfully updated Event!');

        $this->assertDatabaseHas('events', [
            'organization_id' => $user->organization_id,
            'name' => $newName,
            'date_of_event' => $event->date_of_event,
            'num_invites' => $newInvites,
        ]);

        $this->assertDatabaseMissing('events', [
            'organization_id' => $user->organization_id,
            'name' => $event->name,
            'date_of_event' => $event->date_of_event,
            'num_invites' => $event->num_invites,
        ]);
    }

    /**
     * * EventsController@destroy
     * Testing ability to delete an event
     */
    public function test_delete_event()
    {
        $user = $this->loginAs('events_manager');
        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);
        $event->addInvite(factory(Invite::class)->raw(['user_id' => $user->id]));


        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.show', $event))
            ->delete('event/' . $event->id)
            ->assertSuccessful()
            ->assertSee('Successfully deleted Event!')
            ->assertDontSee($event->name);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id
        ]);
    }
}
