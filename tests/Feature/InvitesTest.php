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
        $user = $this->loginAs('basic_user');
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
     * * InviteController@create
     * Testing ability to view the invite guest page
     */
    public function test_can_create_new_invite()
    {
        $user = $this->loginAs('basic_user');
        $event = factory(Event::class)->create(['organization_id' => $user->organization->id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->get(route('invite.create', $event))
            ->assertSuccessful()
            ->assertSee($event->name . ': Add Invite')
            ->assertSee('Guest Name');
    }

    /**
     * * InviteController@store
     * Testing ability to invite guests to an event
     */
    public function test_inviting_guest_to_event()
    {
        $user = $this->loginAs('basic_user');

        $event = factory(Event::class)->create(['organization_id' => $user->organization->id]);
        $guestName = 'Billy Bob';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->post(route('invite.store', $event->id), [
                'guest_name' => $guestName,
            ])
            ->assertSuccessful()
            ->assertSee($guestName . ' has been invited!');
    }

    /**
     * * InviteController@store
     * Testing to make sure you cannot invite a guest that's already invited to an event
     */
    public function test_cannot_insert_duplicates()
    {
        $user = $this->loginAs('basic_user');

        $event = factory(Event::class)->create(['organization_id' => $user->organization->id]);
        $invite = factory(Invite::class)->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'guest_name' => $user->name,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('event.index'))
            ->post(route('invite.store', $event->id), $invite->toArray())
            ->assertSuccessful()
            ->assertSee('primary', $user->name . ' has already been invited!')
            ->assertSee($event->name . ': Add Invite');
    }

    /**
     * * InviteController@destroy
     * Testing ability to delete an invite
     */
    public function test_delete_invite()
    {
        $user = $this->loginAs('basic_user');

        $invite = factory(Invite::class)->create([
            'user_id' => $user->id,
            'guest_name' => $user->name,
        ]);

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('invites.index', $invite->event))
            ->delete(route('invite.destroy', $invite->id))
            ->assertSuccessful()
            ->assertSee('Successfully deleted guest!');

        unset($invite['event']);
        $this->assertDatabaseMissing('invites', $invite->toArray());
    }
}
