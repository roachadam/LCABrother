<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
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
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
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
    public function test_user_can_view_a_login_view(){
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/dash');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/dash');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect('/dash');
        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }
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
