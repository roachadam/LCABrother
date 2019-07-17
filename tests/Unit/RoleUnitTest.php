<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Permission;
use App\Role;

class RoleUnitTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testing ability to set permissions of a user role
     */
    public function test_set_permissions_of_role()
    {
        //Arrange
        $role = $this->arrange();

        //Act
        $permission = $role->setPermissions(factory(Permission::class)->states('manage_members')->raw())->getAttributes();

        //Assert
        $this->assert($role, $permission);
    }

    /**
     * Testing ability to set admin permissions on a role
     */
    public function test_set_admin_permission()
    {
        //Arrange
        $role = $this->arrange();

        //Act
        $permission = $role->setAdminPermissions()->getAttributes();

        //Assert
        $this->assert($role, $permission);
    }

    /**
     * Testing ability to set basic permissions on a role
     */
    public function test_set_basic_permission()
    {
        //Arrange
        $role = $this->arrange();

        //Act
        $permission = $role->setBasicPermissions()->getAttributes();

        //Assert
        $this->assert($role, $permission);
    }

    /**
     * Helper method that seeds the database with needed test data
     */
    private function arrange()
    {
        return factory(Role::class)->state('admin')->create([
            'organization_id' => $this->loginAsAdmin()->organization_id
        ]);
    }

    /**
     * Helper method that handles the assertion for the tests
     */
    private function assert($role, $permission)
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
