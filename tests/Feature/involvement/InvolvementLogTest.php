<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Involvement;
use App\InvolvementLog;

class InvolvementLogTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testing ability to add a new Involvement Log
     */
    public function test_can_add_involvementLog()
    {
        $user = $this->loginAsAdmin();

        $event = factory(Involvement::class)->create(['organization_id' => auth()->user()->organization->id]);
        $dateOfEvent = now()->format('m/d/Y');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('involvement.index'))
            ->post(route('involvementLog.store'), [
                'involvement_id' => $event->id,
                'usersInvolved' => [$user->id],
                'date_of_event' => $dateOfEvent,
            ])
            ->assertSuccessful()
            ->assertSee('Involvement points were logged!')
            ->assertSee($user->name)
            ->assertSee($user->getInvolvementPoints());

        $this->assertDatabaseHas('involvement_logs', [
            'organization_id' => $user->organization->id,
            'user_id' => $user->id,
            'involvement_id' => $event->id,
            'date_of_event' => $dateOfEvent,
        ]);
    }

    /**
     * Testing ability to delete involvement logs
     */
    public function test_can_delete_involvementLog()
    {
        $user = $this->loginAsAdmin();

        $involvementLog = factory(InvolvementLog::class)->create([
            'organization_id' => $user->organization->id,
            'user_id' => $user->id,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->delete('/involvementLog/' . $involvementLog->id)
            ->assertSuccessful()
            ->assertSee('Involvement log deleted!')
            ->assertDontSee(dd($involvementLog->date_of_event));

        $this->assertDatabaseMissing('involvement_logs', $involvementLog->toArray());
    }
}
