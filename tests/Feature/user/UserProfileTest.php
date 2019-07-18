<?php

namespace Tests\Feature;

//use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_profile()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('basic_user');

        $response = $this->get('/users/profile');
        $response->assertStatus(200);
    }

    public function test_can_see_user_details()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAs('basic_user');
        $user->update(['name' => 'John']);

        $response = $this->get('/users/profile');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee($user->phone);
    }

    public function test_can_user_get_edit()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAs('basic_user');

        $response = $this->get('/users/edit');
        $response->assertStatus(200);
    }

    public function test_user_can_edit_email()
    {
        $user = $this->loginAs('basic_user');

        $originalEmail = $user->email;
        $newEmail = 'johndoe@gmail.com';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post('users/update', [
                'email' => $newEmail,
                'phone' => '12224567890',
            ])
            ->assertSuccessful()
            ->assertSee('Updated your details!')
            ->assertSee('Verify Your Email Address');

        $this->assertNotEquals($originalEmail, $user->email);
        $this->assertEquals($newEmail, $user->email);

        $this->assertDatabaseHas('users', [
            'email' => $newEmail,
            'phone' => $user->phone,
            'id' => $user->id,
        ]);
    }

    public function test_user_can_edit_phone()
    {
        $user = $this->loginAs('basic_user');

        $originalPhone = $user->phone;
        $newPhone = '12224567890';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post('users/update', [
                'email' => $user->email,
                'phone' => $newPhone,
            ])
            ->assertSuccessful()
            ->assertSee('Updated your details!')
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->phone);

        $this->assertNotEquals($originalPhone, $user->phone);
        $this->assertEquals($newPhone, $user->phone);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'phone' => $newPhone,
            'id' => $user->id,
        ]);
    }

    public function test_make_avatar_default()
    {
        $this->withoutExceptionHandling();
        $this->loginAs('basic_user');

        $response = $this->post('/avatar/default');
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('users', [
            'id' => auth()->id(),
            'avatar' => 'user.jpg'
        ]);
    }
}
