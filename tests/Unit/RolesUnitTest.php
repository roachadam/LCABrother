<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Permission;
use App\Role;

class RolesUnitTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * * Role->setPermissions($attributes)
     * Testing ability to set permissions of a user role
     */
    public function test_set_permissions_of_role()
    {
        $role = $this->arrange();
        $permission = $role->setPermissions(factory(Permission::class)->states('member_manager')->raw())->getAttributes();
        $this->assert($role, $permission);
    }

    /**
     * * Role->setAdminPermissions()
     * Testing ability to set admin permissions on a role
     */
    public function test_set_admin_permission()
    {
        $role = $this->arrange();
        $permission = $role->setAdminPermissions()->getAttributes();
        $this->assert($role, $permission);
    }

    /**
     * * Role->setBasicPermissions()
     * Testing ability to set basic permissions on a role
     */
    public function test_set_basic_permission()
    {
        $role = $this->arrange();
        $permission = $role->setBasicPermissions()->getAttributes();
        $this->assert($role, $permission);
    }

    /**
     * Helper method that seeds the database with needed test data
     */
    private function arrange(): Role
    {
        return factory(Role::class)->state('admin')->create([
            'organization_id' => $this->loginAs('admin')->organization_id
        ]);
    }

    /**
     * Helper method that handles the assertion for the tests
     */
    private function assert($role, $permission): void
    {
        $this->assertTrue($role->relationLoaded('permission'));
        $this->assertTrue(count(array_intersect($role->permission->getAttributes(), $permission)) === count($permission));

        $this->assertDatabaseHas('roles', [
            'organization_id' => $role->organization_id,
            'permission_id' => $role->permission_id,
            'name' => $role->name,
        ]);

        $this->assertDatabaseHas('permissions', $permission);
    }
}
