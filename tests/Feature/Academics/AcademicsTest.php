<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Academics;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcademicsTest extends TestCase
{

    use RefreshDatabase;
    public function test_can_view_Academics()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/academics');
        $response->assertStatus(200);
    }

    public function test_basic_cannot_view_Academics()
    {
        $this->withoutExceptionHandling();
        $this->loginAsBasic();
        $response = $this->get('/academics');

        $response->assertRedirect('/dash');
        $response->assertStatus(302);
    }

    public function test_can_manage()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $response = $this->get('/academics/manage');
        $response->assertStatus(200);
    }

    public function test_add_academics()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
    }
}
