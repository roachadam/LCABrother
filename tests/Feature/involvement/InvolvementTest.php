<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Involvement;

class InvolvementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testing ability to view Involvement Page as a basic user
     * Ensures basic users are only able to see view their breakdown button
     */
    public function test_involvement_basic_view()
    {
        $this->loginAsBasic();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.index'))
            ->assertSuccessful()
            ->assertSee('Involvement Points')
            ->assertSee('View My Involvement Breakdown')
            ->assertDontSee('Add Involvement Scores')
            ->assertDontSee('Upload Involvement Data');
    }

    /**
     * Testing ability to view Involvement Page as an admin
     * Ensures admins are able to see all the buttons available to them
     */
    public function test_involvement_admin_view()
    {
        $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.index'))
            ->assertSuccessful()
            ->assertSee('Involvement Points')
            ->assertSee('View My Involvement Breakdown')
            ->assertSee('Add Involvement Scores')
            ->assertSee('Upload Involvement Data');
    }

    /**
     * Testing adding an involvement event without any points
     */
    public function test_cannot_add_involvement_without_points()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw([
            'organization_id' => $user->organization->id,
            'points' => ''
        ]);

        $this
            ->post(route('involvement.store'), $event)
            ->assertSessionHasErrors('points');
    }

    /**
     * Testing adding an involvement event without a name
     */
    public function test_cannot_add_involvement_without_name()
    {
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw([
            'organization_id' => auth()->user()->organization->id,
            'name' => ''
        ]);

        $this
            ->post(route('involvement.store'), $event)
            ->assertSessionHasErrors('name');
    }

    /**
     * Testing ability to create new Involvement Event with valid data
     */
    public function test_can_add_involvement()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw(['organization_id' => $user->organization->id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->post(route('involvement.store'), $event)
            ->assertSuccessful()
            ->assertSee('Successfully created and involvement event for ' . $event['name'] . 's')
            ->assertSee($event['name'])
            ->assertSee($event['points']);

        $this->assertDatabaseHas('involvements', [
            "name" => $event['name'],
        ]);
    }

    /**
     * Testing editing involvement event point value with invalid data
     */
    public function test_edit_involvement_event_invalid_point_value()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->create([
            'organization_id' => $user->organization->id,
            'name' => 'Social'
        ]);

        $newPoints = 'test';

        $this
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->patch('involvement/' . $event->id . '/update', [
                'name' => $event->name,
                'points' => $newPoints,
            ])
            ->assertSuccessful()
            ->assertSee('The points must be a number.');

        $this->assertFalse($newPoints === $user->organization->involvement->where('id', $event->id)->first()->points);

        $this->assertDatabaseHas('involvements', $event->toArray());
    }

    /**
     * Testing ability to edit involvement event point value with valid data
     */
    public function test_edit_involvement_event_point_value()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->create([
            'organization_id' => $user->organization->id,
            'name' => 'Social'
        ]);

        $originalPoints = $event->points;
        $newPoints = $event->points + 10;

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->patch('involvement/' . $event->id . '/update', [
                'name' => $event->name,
                'points' => $newPoints,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully updated event!')
            ->assertSee($event->name)
            ->assertSee($newPoints);

        $this->assertFalse($originalPoints === $user->organization->involvement->where('id', $event->id)->first()->points);

        $this->assertDatabaseHas('involvements', [
            'name' => $event->name,
            'points' => $newPoints,
        ]);
    }

    /**
     * Testing editing involvement event name with invalid data
     */
    public function test_edit_involvement_event_invalid_name()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->create([
            'organization_id' => $user->organization->id,
            'name' => 'Social'
        ]);

        $newName = '';

        $this
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->patch('involvement/' . $event->id . '/update', [
                'name' => $newName,
                'points' => $event->points,
            ])
            ->assertSuccessful()
            ->assertSee('The name field is required.');

        $this->assertFalse($newName === $user->organization->involvement->where('id', $event->id)->first()->name);

        $this->assertDatabaseHas('involvements', $event->toArray());
    }

    /**
     * Testing ability to edit involvement event name
     */
    public function test_edit_involvement_event_valid_name()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->create([
            'organization_id' => $user->organization->id,
            'name' => 'Recruitment'
        ]);

        $originalName = $event->name;
        $newName = 'Social';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->patch('involvement/' . $event->id . '/update', [
                'name' => $newName,
                'points' => $event->points,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully updated event!')
            ->assertSee($newName)
            ->assertSee($event->points);

        $this->assertFalse($originalName === $user->organization->involvement->where('id', $event->id)->first()->name);

        $this->assertDatabaseHas('involvements', [
            'name' => $newName,
            'points' => $event->points,
        ]);
    }

    /**
     * Testing ability to delete Involvement Events
     */
    public function test_can_delete_involvement_event()
    {
        $user = $this->loginAsAdmin();
        $event = factory(Involvement::class)->create([
            'organization_id' => $user->organization->id,
            'name' => 'Social'
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->delete('/involvement/' . $event->id)
            ->assertSuccessful()
            ->assertSee('Event has been deleted!')
            ->assertDontSee($event->name);

        $this->assertDatabaseMissing('involvements', $event->toArray());
    }
}
