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

    public function test_view_goals(){
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $org = $user->organization;
        $goals = factory(Goals::class)->raw();

        $response = $this->post('/goals/store', $goals);

        $response = $this->get('/goals');

        $response->assertSee($goals['points_goal']);
        $response->assertSee($goals['service_hours_goal']);
        $response->assertSee($goals['service_money_goal']);
        $response->assertSee($goals['study_goal']);
    }
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

    public function test_cannot_submit_nonInt_goals(){
        //$this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $attributes = factory(Goals::class)->raw(['study_goal' => 'fish']);
        $response = $this->post('/goals/store', $attributes);
        $response->assertSessionHasErrors('study_goal');

    }

    public function test_cannot_submit_huge_goals(){
        //$this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $attributes = factory(Goals::class)->raw(['points_goal' => '10000000000000000']);
        $response = $this->post('/goals/store', $attributes);
        $response->assertSessionHasErrors('points_goal');
    }

    public function test_cannot_submit_negative_goals(){
        //$this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $attributes = factory(Goals::class)->raw(['service_hours_goal' => '-4323']);
        $response = $this->post('/goals/store', $attributes);
        $response->assertSessionHasErrors('service_hours_goal');

    }

    public function test_cannot_submit_null_goals(){
        //$this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $attributes = factory(Goals::class)->raw(['service_money_goal' => '']);
        $response = $this->post('/goals/store', $attributes);
        $response->assertSessionHasErrors('service_money_goal');
    }

    public function test_can_get_edit_view(){
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $goals = factory(Goals::class)->raw();

        $response = $this->post('/goals/store', $goals);

        $response = $this->get('/goals/edit');
        $response->assertstatus(200);
    }
    public function test_edit_goals(){
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();
        $org = $user->organization;
        
        $goals = factory(Goals::class)->raw();
        $response = $this->post('/goals/store', $goals);

        $GoalObj =  DB::table('goals')->where('points_goal', $goals['points_goal'])->first();

        $edittedGoals = factory(Goals::class)->raw();
        $response = $this->post('/goals/'. $GoalObj->id .'/update', $edittedGoals);

        $this->assertDatabaseMissing('goals',[
            'organization_id' => $org->id,
            'points_goal' => $goals['points_goal'],
            'service_hours_goal' => $goals['service_hours_goal'],
            'service_money_goal' => $goals['service_money_goal'],
            'study_goal' => $goals['study_goal'],
        ]);
        $this->assertDatabaseHas('goals',[
            'organization_id' => $org->id,
            'points_goal' => $edittedGoals['points_goal'],
            'service_hours_goal' => $edittedGoals['service_hours_goal'],
            'service_money_goal' => $edittedGoals['service_money_goal'],
            'study_goal' => $edittedGoals['study_goal'],
        ]);

        $response->assertRedirect('/goals');

    }
}
