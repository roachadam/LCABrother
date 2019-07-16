<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Admin Tests
     */
    public function test_admin_can_visit_dash()
    {
        $this->loginAsAdmin();

        $response = $this->get('/dash');
        $response->assertStatus(200);
    }

    public function test_admin_can_visit_user()
    {
        $this->loginAsAdmin();

        $response = $this->get('/user');
        $response->assertStatus(200);
    }

    public function test_admin_can_visit_role()
    {
        $this->loginAsAdmin();

        $response = $this->get('/role');
        $response->assertStatus(200);
    }

    public function test_admin_can_visit_user_contact()
    {
        $this->loginAsAdmin();

        $response = $this->get('/users/contact');
        $response->assertStatus(200);
    }

    public function test_admin_can_visit_serviceEvent()
    {
        $this->loginAsAdmin();

        $response = $this->get('/serviceEvent');
        $response->assertStatus(200);
    }
}
