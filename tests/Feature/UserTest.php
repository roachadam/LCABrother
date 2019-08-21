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
        $user = $this->loginAs('member_manager');

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
        $user = $this->loginAs('basic_user');
        $org = factory(Organization::class)->create();

        $previousOrgId = $user->organization_id;

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->post('/user/' . $user->id . '/join', [
                'organization' => $org->id,
            ])
            ->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'organization_id' => $previousOrgId,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'organization_id' => $org->id,
        ]);
    }
}
