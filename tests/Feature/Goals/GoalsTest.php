<?php

namespace Tests\Feature;

use App\User;
use App\Goals;
use App\Organization;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_goals()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $org = $user->organization;
        $goals = factory(Goals::class)->raw();

        $response = $this->post('/goals/store', $goals);

        $this->assertDatabaseHas('goals',[
            'organization_id' => $org->id,
            'points_goal' => $goals['points_goal'],
            'service_hours_goal' => $goals['service_hours_goal'],
            'service_money_goal' => $goals['service_money_goal'],
            'study_goal' => $goals['study_goal'],
        ]);
        $response->assertRedirect('/role');
    }
}
