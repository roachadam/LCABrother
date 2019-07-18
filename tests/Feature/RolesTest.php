<?php

namespace Tests\Feature;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Permission;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing ability of admin to view roles page
     */
    public function test_can_view_roles_page()
    {
        $roles = $this->loginAsAdmin()->organization->roles;

        $this
            ->get(route('role.index'))
            ->assertSee('Roles');

        foreach ($roles as $role) {
            $this
                ->get('/role')
                ->assertSee($role->name);
        }
    }

    /**
     * Testing ability to add new role
     */
    public function test_can_add_role()
    {
        $user = $this->loginAsAdmin();

        $newRoleName = 'President';
        $role = factory(Role::class)->raw([
            'name' => $newRoleName,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('role.index'))
            ->post(route('role.store'), [
                "name" => $role['name'],
                "manage_member_details" => "on",
                "manage_all_involvement" => "on",
            ])
            ->assertSuccessful()
            ->assertSee('Added role!')
            ->assertSee($role['name']);

        $this->assertEquals($newRoleName, $role['name']);

        $this->assertDatabaseHas('roles', [
            "name" => $role['name'],
        ]);
    }

    // public function test_edit_role()
    // {
    //     $user = $this->loginAsAdmin();

    //     dd($user->organization->roles);
    // }


    //Future tests

    //public function test_assign_user_role() { }



    //public function test_view_members_in_role() { }

    //public function test_delete_role() { }
}
