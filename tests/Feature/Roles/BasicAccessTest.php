<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_can_visit_dash(){
        $this->loginAsBasic();

        $response = $this->get('/dash');
        $response->assertStatus(200);
    }

    public function test_basic_cannot_visit_user(){
        $this->loginAsBasic();

        $response = $this->get('/user');
        $response->assertRedirect('/dash');
    }
    public function test_basic_cannot_visit_role(){
        $this->loginAsBasic();

        $response = $this->get('/role');
        $response->assertRedirect('/dash');
    }
    public function test_basic_cannot_visit_userContact(){
        $this->loginAsBasic();

        $response = $this->get('/users/contact');
        $response->assertRedirect('/dash');
    }
    public function test_basic_cannot_visit_serviceEvent(){
        $this->loginAsBasic();

        $response = $this->get('/serviceEvent');
        $response->assertRedirect('/dash');
    }
    public function test_basic_cannot_visit_serviceEventCreate(){
        $this->loginAsBasic();

        $response = $this->get('/serviceEvent/create');
        $response->assertRedirect('/dash');
    }
}
