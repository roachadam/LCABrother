<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\Involvement;

class InvolvementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * * InvolvementController@index
     * Testing ability to view Involvement Page as a basic user
     * Ensures basic users are only able to see view their breakdown button
     */
    public function test_involvement_basic_view()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.index'))
            ->assertSuccessful()
            ->assertSee('Involvement Points')
            ->assertSee('My Involvement Breakdown')
            ->assertDontSee('Add Involvement Scores')
            ->assertDontSee('Upload Involvement Data')
            ->assertDontSee('View');
    }

    /**
     * * InvolvementController@index
     * Testing ability to view Involvement Page as the Involvement Manager
     * Ensures admins are able to see all the buttons available to them
     */
    public function test_involvement_admin_view()
    {
        $this->loginAs('involvement_manager');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.index'))
            ->assertSuccessful()
            ->assertSee('Involvement Points')
            ->assertSee('My Involvement Breakdown')
            ->assertSee('Add Involvement Scores')
            ->assertSee('Upload Involvement Data')
            ->assertSee('View');
    }

    /**
     * * InvolvementController@store
     * Testing adding an involvement event without any points
     */
    public function test_cannot_add_involvement_without_points()
    {
        $user = $this->loginAs('involvement_manager');
        $event = factory(Involvement::class)->raw([
            'organization_id' => $user->organization->id,
            'points' => ''
        ]);

        $this
            ->post(route('involvement.store'), $event)
            ->assertSessionHasErrors('points');
    }

    /**
     * * InvolvementController@store
     * Testing adding an involvement event without a name
     */
    public function test_cannot_add_involvement_without_name()
    {
        $user = $this->loginAs('involvement_manager');
        $event = factory(Involvement::class)->raw([
            'organization_id' => $user->organization_id,
            'name' => ''
        ]);

        $this
            ->post(route('involvement.store'), $event)
            ->assertSessionHasErrors('name');
    }

    /**
     * * InvolvementController@store
     * Testing adding a duplicate involvement event
     */
    public function test_cannot_add_duplicate_involvement_event()
    {
        $user = $this->loginAs('involvement_manager');

        $event = factory(Involvement::class)->create([
            'name' => 'Social',
            'organization_id' => $user->organization_id,
        ])->toArray();
        $event['test'] = true;

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->post(route('involvement.store'), $event)
            ->assertSuccessful()
            ->assertSee('An Involvement event for ' . $event['name'] . 's already exits');

        $this->assertTrue($user->organization->involvement->where('name', $event['name'])->count() === 1);
    }

    /**
     * * InvolvementController@store
     * Testing ability to create new Involvement Event with valid data
     */
    public function test_can_add_involvement()
    {
        $user = $this->loginAs('involvement_manager');
        $event = factory(Involvement::class)->raw(['organization_id' => $user->organization->id]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.adminView'))
            ->post(route('involvement.store'), $event)
            ->assertSuccessful()
            ->assertSee('Successfully created involvement event for ' . $event['name'] . 's')
            ->assertSee($event['name'])
            ->assertSee($event['points']);

        $this->assertDatabaseHas('involvements', [
            'name' => $event['name'],
        ]);
    }

    /**
     * * InvolvementController@update
     * Testing editing involvement event point value with invalid data
     */
    public function test_edit_involvement_event_invalid_point_value()
    {
        $user = $this->loginAs('involvement_manager');
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
     * * InvolvementController@update
     * Testing ability to edit involvement event point value with valid data
     */
    public function test_edit_involvement_event_point_value()
    {
        $user = $this->loginAs('involvement_manager');
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
     * * InvolvementController@update
     * Testing editing involvement event name with invalid data
     */
    public function test_edit_involvement_event_invalid_name()
    {
        $user = $this->loginAs('involvement_manager');
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
     * * InvolvementController@update
     * Testing ability to edit involvement event name
     */
    public function test_edit_involvement_event_valid_name()
    {
        $user = $this->loginAs('involvement_manager');
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
     * * InvolvementController@import
     * Testing uploading an invalid file (in this case its empty)
     */
    public function test_upload_invalid_file()
    {
        $user = $this->loginAs('involvement_manager');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.index'))
            ->post(route('involvement.import'), [
                'InvolvementData' => new UploadedFile('storage\app\public\grades\testFile\gradesTestFail.xlsx', 'gradesTestFail.xlsx', 'xlsx', null, true),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Failed to import new Records: Invalid format');

        $this->assertTrue($user->organization->academics->filter(function ($academic) {
            return $academic['name'] !== null && $academic['Cumulative_GPA'] !== null && $academic['Current_Term_GPA'] !== null;
        })->values()->isEmpty());
    }

    /**
     * * InvolvementController@import
     * Testing uploading a valid file when the organization already had all the events created
     */
    public function test_upload_file_with_existing_events()
    {
        $user = $this->loginAs('involvement_manager');
        $user->update(['name' => 'Jacob Drury']);

        $events = $this->preloadInvolvementEvents($user->organization_id);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.index'))
            ->post(route('involvement.import'), [
                'InvolvementData' => new UploadedFile('storage\app\public\involvement\testFiles\pointsTestWorking.xlsx', 'pointsTestWorking.xlsx', 'xlsx', null, true),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully imported new Involvement records!');

        $involvements = $user->organization->involvement->filter(function ($involvement) {
            return $involvement['name'] !== null && $involvement['points'] !== null;
        })->values();

        $this->assertTrue($involvements->isNotEmpty() && $involvements->count() === ($events->count() + 1));            //Plus one for a random event created from one of the factories

        foreach ($events as $event) {
            $this->assertDatabaseHas('involvements', $event->toArray());
        }
    }


    /**
     * * InvolvementController@import
     * Testing uploading a valid file when the organization doesn't have any existing events
     * and makes sure it brings you to the page to fill out points for the created events
     */
    public function test_upload_file_without_existing_events()
    {
        $user = $this->loginAs('involvement_manager');
        $user->update(['name' => 'Jacob Drury']);

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.index'))
            ->post(route('involvement.import'), [
                'InvolvementData' => new UploadedFile('storage\app\public\involvement\testFiles\pointsTestWorking.xlsx', 'pointsTestWorking.xlsx', 'xlsx', null, true),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Edit Involvement Event Points');

        $eventNames = $user->organization->involvement->filter(function ($involvement) {
            return $involvement['name'] !== null && $involvement['points'] == null;
        })->values()->pluck('name');

        foreach ($eventNames as $eventName) {
            $response->assertSee($eventName);
        }
    }

    /**
     * * InvolvementController@setPoints
     * Testing uploading a valid file
     */
    public function test_setting_event_point_value_when_auto_created()
    {
        $pointValues = collect();
        $user = $this->loginAs('involvement_manager');

        $involvements = $this->preloadInvolvementEvents($user->organization_id, true);

        $names = $involvements->pluck('name');

        foreach ($names as $name) {
            $pointValues->push(rand(1, 100));
        }

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->post(route('involvement.setPoints'), [
                'name' => $names->toArray(),
                'point_value' => $pointValues->toArray(),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully imported new Involvement records!');

        foreach ($names->combine($pointValues) as $name => $pointValue) {
            $this->assertDatabaseHas('involvements', [
                'organization_id' => $user->organization_id,
                'name' => $name,
                'points' => $pointValue,
            ]);
        }
    }

    /**
     * * InvolvementController@adminView
     * Testing to ensure a basic user cannot view the events breakdown
     */
    public function test_basic_user_cannot_get_admin_view()
    {
        $this->loginAs('basic_user');

        $this
            ->get(route('involvement.adminView'))
            ->assertRedirect('/dash');
    }

    /**
     * * InvolvementController@adminView
     * Testing ability of the involvement manager to view the admin breakdown
     */
    public function test_can_get_admin_view()
    {
        $user = $this->loginAs('involvement_manager');

        $involvements = $this->preloadInvolvementEvents($user->organization_id);

        $response = $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.adminView'))
            ->assertSuccessful()
            ->assertSee('Involvement Events')
            ->assertSee('Create New');

        foreach ($involvements as $involvement) {
            $response
                ->assertSee($involvement->name)
                ->assertSee($involvement->points);
        }
    }

    /**
     * * InvolvementController@destroy
     * Testing ability to delete Involvement Events
     */
    public function test_can_delete_involvement_event()
    {
        $user = $this->loginAs('involvement_manager');
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

    private function preloadInvolvementEvents($organization_id, $nullPoints = false)
    {
        return collect([
            "Recruitment events",
            "Philanthropy events",
            "Brotherhood events",
            "Intramurals",
            "Socials",
            "Pay dues in full",
            "PI",
            "Attend other organizations events",
            "Leadership role in another organization",
            "Move into the house",
        ])->map(function ($name) use ($organization_id, $nullPoints) {
            return factory(Involvement::class)->create([
                'organization_id' => $organization_id,
                'name' => $name,
                'points' => $nullPoints ? null : rand(1, 100),
            ]);
        });
    }
}
