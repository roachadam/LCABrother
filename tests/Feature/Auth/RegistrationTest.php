<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_a_register_view()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testRegistersAValidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123!',
            'password_confirmation' => 'secret123!'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function testDoesNotRegisterAnInvalidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->post('register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
