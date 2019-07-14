<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\InvolvementLog;
use App\ServiceEvent;
use Tests\TestCase;
use App\ServiceLog;
use App\Goals;

class TotalsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing ability to view the Totals page
     */
    public function test_get_index()
    {
        $user = $this->loginAsAdmin();

        $goals = factory(Goals::class)->create([
            'organization_id' => $user->organization_id,
            'points_goal' => 1,
            'study_goal' => 2,
            'service_hours_goal' => 3,
            'service_money_goal' => 4
        ]);

        $this
            ->withoutExceptionHandling()
            ->get(route('totals.index'))
            ->assertSuccessful()
            ->assertSee('Involvement Points Goal')
            ->assertSee($goals->points_goal)
            ->assertSee('Study Hours Goal')
            ->assertSee($goals->study_goal)
            ->assertSee('Service Hours Goal')
            ->assertSee($goals->service_hours_goal)
            ->assertSee('Money Donated Goal')
            ->assertSee($goals->service_money_goal);
    }

    /**
     * Testing the ability to mark the start of a new semester from the totals page
     */
    public function test_start_new_semester()
    {
        $user = $this->loginAsAdmin();

        $this->arrange($user);

        $oldSemester = $user->organization->getActiveSemester();

        $newSemesterName = 'Fall 8080';

        $this->assertFalse($this->correctActiveLogs($user, $newSemesterName));

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('totals.index'))
            ->post(route('semester.store'), [
                'semester_name' => $newSemesterName,
            ])
            // ->assertSuccessful()
            ->assertSee('Successfully created new semester!')
            ->assertSee($newSemesterName);

        $this->assertFalse($user->organization->getActiveSemester()->is($oldSemester));

        $this->assertTrue($this->correctActiveLogs($user, $newSemesterName));

        $this->assertDatabaseHas('semesters', [
            'organization_id' => $user->organization_id,
            'semester_name' => $newSemesterName,
            'active' => 1
        ]);
    }

    /**
     * Helper method that checks if the active logs exist and if the active semester equals the new semester name
     */
    private function correctActiveLogs($user, $newSemesterName): bool
    {
        return $user->getActiveServiceLogs()->isEmpty() &&
            $user->getActiveInvolvementLogs()->isEmpty() &&
            $user->organization->getActiveSemester()->semester_name === $newSemesterName;
    }

    /**
     * Helper method that seeds the database with needed test data
     */
    private function arrange($user): void
    {
        $serviceEventIds = factory(ServiceEvent::class, 10)->create([
            'organization_id' => $user->organization_id,
        ])->pluck('id');

        factory(ServiceLog::class, 50)->create([
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
            'service_event_id' => $serviceEventIds->random(),
        ]);

        factory(InvolvementLog::class, 50)->create([
            'organization_id' => $user->organization->id,
            'user_id' => $user->id,
        ]);
    }
}
