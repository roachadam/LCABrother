<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Goals;

class totalsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function get_index()
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
}
