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
        $this->loginAsAdmin();
        factory(Goals::class)->create(['organization_id' => auth()->user()->organization->id]);

        $this
            ->withoutExceptionHandling()
            ->get('/totals')
            ->assertStatus(200);
    }
}
