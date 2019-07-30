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
     * Testing ability to create an Event with valid data
     */
    public function test_get_user_guest_list()
    {
        //$this->withoutExceptionHandling();
        $user = $this->loginAs('events_manager');
        $user2 = factory(User::class)->create(['organization_id' => $user->organization_id]);

        $event = factory(Event::class)->create(['organization_id' => $user->organization_id]);
        $inviteAttributes1 = factory(Invite::class)->raw([
            'guest_name' => 'Bobby',
            'user_id' => $user->id,
        ]);
        $event->addInvite($inviteAttributes1);
        $inviteAttributes2 = factory(Invite::class)->raw([
            'guest_name' => 'Jane',
            'user_id' => $user->id,
        ]);
        $event->addInvite($inviteAttributes2);
        $inviteAttributes3 = factory(Invite::class)->raw([
            'guest_name' => 'John',
            'user_id' => $user->id,
        ]);
        $event->addInvite($inviteAttributes3);

        $response = $this->get('user/' . $event->id . '/invites');

        $response->assertSee($inviteAttributes1['guest_name']);
        $response->assertSee($inviteAttributes2['guest_name']);
        //$response->assertDontSee($inviteAttributes3['guest_name']);
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
