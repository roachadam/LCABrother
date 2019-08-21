<?php

namespace Tests\Feature;

use App\Goals;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailBelowTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_get_notify_index()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('admin');

        $goals = factory(Goals::class)->create();
        $response = $this->get('/goals/' . $goals->id . '/notify');
        $response->assertOk();
        $response->assertSee($goals->points_goal);
        $response->assertSee($goals->study_goal);
        $response->assertSee($goals->service_hours_goal);
        $response->assertSee($goals->service_money_goal);
    }
}
