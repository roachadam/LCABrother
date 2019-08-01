<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Organization;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * UserController@index
     * Testing ability to view the users
     */
    public function test_get_admin_view()
    {
        $user = $this->loginAs('member_manager');

        $users = factory(User::class, 5)->create(['organization_id' => $user->organization_id])->push($user);

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('user.index'))
            ->assertSuccessful()
            ->assertSee('Members');

        foreach ($users as $user) {
            $response
                ->assertSee($user->name)
                ->assertSee($user->role->name);
        }
    }

    /**
     * * UserController@destroy
     * Testing ability to delete a user
     */
    public function test_can_delete_user()
    {
        $user = $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->delete(route('user.destroy', $user))
            ->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
        ]);
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
