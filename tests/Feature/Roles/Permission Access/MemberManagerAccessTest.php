<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberManagerAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_MemberManager_can_visit_dash()
    {
        $this->loginAsMemberManager();

        $response = $this->get('/dash');
        $response->assertStatus(200);
    }

    public function test_MemberManager_cannot_visit_user()
    {
        $this->loginAsMemberManager();

        $response = $this->get('/user');
        $response->assertRedirect('/dash');
    }

    public function test_MemberManager_can_visit_role()
    {
        $this->loginAsMemberManager();

        $response = $this->get('/role');
        $response->assertStatus(200);
    }

    public function test_basic_MemberManager_visit_userContact()
    {
        $this->loginAsMemberManager();

        $response = $this->get('/users/contact');
        $response->assertRedirect('/dash');
    }
}
