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
        $this->loginAsAdmin();

        $response = $this->get('/users/profile');
        $response->assertStatus(200);
    }

    public function test_can_see_user_details()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $response = $this->get('/users/profile');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee($user->phone);
    }

    public function test_can_user_get_edit()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        $response = $this->get('/users/edit');
        $response->assertStatus(200);

    }

    public function test_can_user_edit_details()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();
        $phone = $user->phone;
        $response = $this->post('users/update',[
            'phone' => '12224567890',
        ]);
        $this->assertDatabaseMissing('users',[
            'phone' => $phone,
            'id' => $user->id,
        ]);
        $this->assertDatabaseHas('users',[
            'phone' => '12224567890',
            'id' => $user->id,
        ]);

    }
}


