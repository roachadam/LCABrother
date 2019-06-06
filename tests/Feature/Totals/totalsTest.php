<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class totalsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function get_index()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/totals');

        $response->assertStatus(200);
    }

}
