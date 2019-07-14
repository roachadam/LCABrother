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
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw([
            'organization_id' => auth()->user()->organization->id,
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
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw(['organization_id' => auth()->user()->organization->id]);

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
     * Testing ability to edit involvement event point value
     */
    public function test_edit_involvement_event_point_value()
    {
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->create(['organization_id' => auth()->user()->organization->id]);
    }

    /**
     * Testing ability to edit involvement event name
     */
    public function test_edit_involvement_event_name()
    { }

    /**
     * Testing ability to delete Involvement Events
     */
    public function test_can_delete_involvement_event()
    { }
}
