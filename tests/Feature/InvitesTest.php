<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Invite;
use App\Event;
use App\User;

class InvitesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * InviteController@index
     * Testing ability to view a user's invited guests
     */
    public function test_get_user_guest_list()
    {
        $user = $this->loginAs('events_manager');
        $user2 = factory(User::class)->create(['organization_id' => $user->organization_id]);

        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);

        $event->addInvite(factory(Invite::class)->raw(['guest_name' => 'Sally', 'user_id' => $user2->id]));
        $event->addInvite(factory(Invite::class)->raw(['guest_name' => 'Sue', 'user_id' => $user2->id]));
        $event->addInvite(factory(Invite::class)->raw(['guest_name' => 'Billy', 'user_id' => $user->id]));
        $event->addInvite(factory(Invite::class)->raw(['guest_name' => 'Bob', 'user_id' => $user->id]));

        //Clears the notifications from the guests being invited
        Session()->flush();

        $response = $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->get(route('invites.index', $event))
            ->assertSuccessful()
            ->assertSee('Your guestlist for ' . $event->name);

        foreach ($user->getInvites($event) as $invite) {
            $response->assertSee($invite->guest_name);
        }

        foreach ($user2->getInvites($event) as $invite) {
            $response->assertDontSee($invite->guest_name);
        }
    }

    /**
     * * InviteController@destroy
     * Testing ability to create an Event with valid data
     */
    public function test_delete_invite()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('events_manager');

        $invite = factory(Invite::class)->create(['user_id' => auth()->id()]);
        $inviteArray = $invite->toArray();
        $response = $this->delete('invite/' . $invite->id);
        $this->assertDatabaseMissing('invites', $inviteArray);
    }

    /**
     * * InviteController@store
     * Testing ability to create an Event with valid data
     */
    public function test_cannot_insert_duplicates()
    {
        $user = $this->loginAs('events_manager');

        $event = factory(Event::class)->create(['organization_id' => $user->organization->id]);
        $invite = factory(Invite::class)->raw([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'guest_name' => $user->name,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('invite.store', $event->id), $invite)
            ->assertSuccessful()
            ->assertSee('Events')
            ->assertSee($event->name)
            ->assertSee('1');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('invite.store', $event->id), $invite)
            ->assertSuccessful()
            ->assertSee('primary', $user->name . ' has already been invited!')
            ->assertSee($event->name . ': Add Invite');
    }
}
