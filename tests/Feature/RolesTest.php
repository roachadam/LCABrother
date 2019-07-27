<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Role;
use App\User;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * RoleController@index
     * Testing ability of basic user to access the roles page
     */
    public function test_basic_user_cannot_view_roles_page()
    {
        $roles = $this->loginAs('basic_user')->organization->roles;

        $response = $this
            ->get(route('role.index'))
            ->assertRedirect('/dash')
            ->assertDontSee('Roles');

        foreach ($roles as $role) {
            $response->assertDontSee($role->name);
        }
    }


    /**
     * * RoleController@index
     * Testing ability of admin to view roles page
     */
    public function test_member_manager_can_view_roles_page()
    {
        $roles = $this->loginAs('member_manager')->organization->roles;

        $response = $this
            ->get(route('role.index'))
            ->assertSee('Roles');

        foreach ($roles as $role) {
            $response->assertSee($role->name);
        }
    }

    /**
     * * RoleController@store
     * Testing ability to add new role
     */
    public function test_can_add_role()
    {
        $user = $this->loginAs('member_manager');

        $newRoleName = 'President';
        $role = factory(Role::class)->raw([
            'organization_id' => $user->organization_id,
            'name' => $newRoleName,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.index'))
            ->post(route('role.store'), [
                'name' => $role['name'],
                'manage_member_details' => '1',
                'manage_all_involvement' => '1',
            ])
            ->assertSuccessful()
            ->assertSee('Added role!')
            ->assertSee($role['name']);

        $this->assertEquals($newRoleName, $role['name']);

        $this->assertDatabaseHas('permissions', [
            'manage_member_details' => '1',
            'manage_all_involvement' => '1',
            'view_member_details' => '0',
            'log_service_event' => '0',
            'view_all_service' => '0',
            'view_all_involvement' => '0',
            'manage_all_service' => '0',
            'manage_events' => '0',
            'manage_forum' => '0',
            'manage_alumni' => '0',
            'manage_surveys' => '0',
            'view_all_study' => '0',
            'manage_all_study' => '0',
            'manage_calendar' => '0',
            'take_attendance' => '0',
            'manage_goals' => '0',
        ]);

        $this->assertDatabaseHas('roles', [
            'organization_id' => $user->organization_id,
            'name' => $role['name'],
        ]);
    }

    /**
     * * RoleController@edit
     * Testing the ability of the member manager to view the edit role page
     */
    public function test_can_view_edit_role_page()
    {
        $user = $this->loginAs('member_manager');

        $role = $this->arrange($user);

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('role.index'))
            ->get(route('role.edit', $role))
            ->assertSuccessful()
            ->assertSee('Edit ' . $role->name . ' Permissions');
    }

    /**
     * * RoleController@update
     * Testing the ability of the member manager to submit the edit role page and update it's permissions
     */
    public function test_can_edit_role()
    {
        $user = $this->loginAs('member_manager');

        $role = $this->arrange($user);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.edit', $role))
            ->patch(route('role.update', $role), [
                'view_member_details' => 'on',
                'view_all_study' => 'on',
                'manage_calendar' => 'on',
            ])
            ->assertSuccessful()
            ->assertSee('Updated role!');

        $this->assertDatabaseHas('permissions', [
            'view_member_details' => '1',
            'manage_member_details' => '0',
            'log_service_event' => '0',
            'view_all_service' => '0',
            'view_all_involvement' => '0',
            'manage_all_service' => '0',
            'manage_all_involvement' => '0',
            'manage_events' => '0',
            'manage_forum' => '0',
            'manage_alumni' => '0',
            'manage_surveys' => '0',
            'view_all_study' => '1',
            'manage_all_study' => '0',
            'manage_calendar' => '1',
            'take_attendance' => '0',
            'manage_goals' => '0',
        ]);
    }

    /**
     * * RoleController@destroy
     * Testing the ability of the member manager to delete a role and have it assign all users who had it to basic
     */
    public function test_delete_role()
    {
        $user = $this->loginAs('member_manager');

        $role = $this->arrange($user);

        $extraUser = factory(User::class)->create([
            'organization_id' => $user->organization_id,
        ]);

        $extraUser->setRole($role);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.edit', $role))
            ->delete(route('role.destroy', $role))
            ->assertSuccessful()
            ->assertSee('Successfully deleted role!');

        $extraUser->refresh();

        $this->assertEquals('Basic', $extraUser->role->name);

        $this->assertDatabaseMissing('roles', $role->toArray());
    }

    /**
     * * RoleController@usersInRole
     * Testing the ability of the member manager view members of the corresponding role
     */
    public function test_view_members_in_role()
    {
        $manager = $this->loginAs('member_manager');
        $role = $manager->organization->roles->where('name', 'Basic')->first();

        $users = factory(User::class, 10)->create([
            'organization_id' => $manager->organization_id,
            'role_id' => 2,
        ]);

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.index'))
            ->get(route('role.usersInRole', $role))
            ->assertSuccessful();

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }


    /**
     * * RoleController@massSet
     * Testing the ability of the member manager to assign a user to a new role
     */
    public function test_assign_user_role()
    {
        $user = $this->loginAs('member_manager');
        $role = $user->organization->roles->where('name', 'Basic')->first();

        $previousRoleName = $user->role->name;

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.usersInRole', $role))
            ->post(route('role.massSet', $role), [
                'users' => [$user->id],
            ])
            ->assertSuccessful()
            ->assertSee('Successfully Assigned New Roles!');

        $user->refresh();

        $this->assertNotEquals($previousRoleName, $user->role->name);
        $this->assertEquals('Basic', $user->role->name);
    }


    /**
     * * RoleController@removeRole
     * Testing the ability of the member manager to remove a user from a role
     */
    public function test_remove_user_from_role()
    {
        $user = $this->loginAs('member_manager');

        $previousRoleName = $user->role->name;

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.usersInRole', $user->role))
            ->patch(route('user.removeRole', $user))
            ->assertSuccessful()
            ->assertSee('Successfully removed user!');

        $user->refresh();

        $this->assertNotEquals($previousRoleName, $user->role->name);
        $this->assertEquals('Basic', $user->role->name);
    }


    /**
     * Helper function to load data needed to run tests
     */
    private function arrange(User $user): Role
    {
        return factory(Role::class)->state('service_logger')->create([
            'organization_id' => $user->organization_id,
            'name' => 'service_logger',
        ]);
    }
}
