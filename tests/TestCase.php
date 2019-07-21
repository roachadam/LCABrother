<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Organization;
use Notification;
use App\Semester;
use App\Role;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Set up the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    /**
     * Helper function for all tests that logs in as a specific role
     * and creates the corresponding permission
     */
    protected function loginAs($name): User
    {
        $user = $this->createRole(strtolower($name));
        $this->actingAs($user);
        return $user;
    }

    /**
     * Created the desired role and returns the user it is associated with
     */
    private function createRole($name): User
    {
        $user = factory(User::class)->create([
            'organization_id' => rand(1, 999),
        ]);

        $organization = $this->getOrganization($user);
        $user->join($organization);

        $role = $this->getRole($name, $organization);

        $user->setRole($role);

        $this->setSemester($organization);

        return $user;
    }

    /**
     * Checks if the role already exists in the database and returns it if it does
     * If it doesn't then it creates and return a new role with the given name
     */
    private function getRole($name, $organization): Role
    {
        $name = $this->getNewName($name);
        $storedRole = $organization->roles->where('name', $name)->first();

        return isset($storedRole) ? $storedRole : factory(Role::class)->state($name)->create([
            'organization_id' => $organization->id,
            'name' => $name,
        ]);
    }

    /**
     * Creates and returns an Organization with the passed user as the owner
     */
    private function getOrganization(User $user): Organization
    {
        return factory(Organization::class)->create([
            'id' => $user->organization_id,
            'owner_id' => $user->id
        ]);
    }

    /**
     * Makes sure there is an active semester set
     */
    private function setSemester($organization)
    {
        if (Semester::all()->isEmpty()) {
            factory(Semester::class)->create(['organization_id' => $organization->id]);
        }
    }

    /**
     * This function helps translate the tests naming for the roles to what the organization models create on initialization
     */
    private function getNewName($name): string
    {
        $specialRole = collect(['Basic' => 'basic_user', 'Admin' => 'admin'])->search($name);
        return $specialRole !== false ? $specialRole : $name;
    }
}
