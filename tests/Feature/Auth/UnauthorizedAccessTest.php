<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnauthorizedAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_user_cannot_visit_dash(){
        $response = $this->get('/dash');
        $response->assertRedirect('login');
    }
    public function test_unauthorized_user_cannot_visit_user(){
        $response = $this->get('/user');
        $response->assertRedirect('login');
    }
    public function test_unauthorized_user_cannot_visit_role(){
        $response = $this->get('/role');
        $response->assertRedirect('login');
    }
    public function test_unauthorized_user_cannot_visit_user_contact(){
        $response = $this->get('/users/contact');
        $response->assertRedirect('login');
    }
    public function test_unauthorized_user_cannot_visit_serviceEvent(){
        $response = $this->get('/serviceEvent');
        $response->assertRedirect('login');
    }
    public function test_unauthorized_user_cannot_visit_serviceEventCreate(){
        $response = $this->get('/serviceEvent/create');
        $response->assertRedirect('login');
    }
}
