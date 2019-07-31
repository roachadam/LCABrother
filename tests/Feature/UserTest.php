<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Organization;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_register_user()
    {
        $user = factory(User::class)->make();
        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post('/register', [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => 'secret123!=-',
                'password_confirmation' => 'secret123!=-'
            ])
            ->assertSuccessful()
            ->assertSee('Add Avatar');
    }

    /**
     * * UserController@joinOrg
     * Testing the ability to create a new organization
     */
    public function test_join_Organization()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();
        $org = factory(Organization::class)->create();

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123!=-',
            'password_confirmation' => 'secret123!=-'
        ]);
        $dbUser =  User::where('email', $user->email)->first();


        $response = $this->post('/user/' . $dbUser->id . '/join', [
            'organization' => $org->id,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'organization_id' => $org->id,
        ]);
        $response->assertRedirect('/dash');
    }
}
