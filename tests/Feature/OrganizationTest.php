<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function registerUser(){
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);
        return $response;
    }
    public function test_get_createOrganization_page()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response->assertRedirect('/organization');
        $response = $this->get('/organization/create');
        $response->assertStatus(200);
    }

    public function test_create_Organization()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response->assertRedirect('/organization');
        $response = $this->post('/user/'+ $user->id,[
            
        ]);
        $response->assertStatus(200);
    }
}
