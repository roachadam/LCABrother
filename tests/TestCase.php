<?php

namespace Tests;

use App\Role;
use App\User;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Notification;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Organization;
use App\Semester;

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

    protected function createAdmin($organization = null)
    {
        if ($organization !== null) {
            $user = factory(User::class)->create(['organization_id' => $organization->id]);
        } else {
            $user = factory(User::class)->create();
            $organization = $this->getOrganization($user);
        }
        $this->setSemester($organization);

        $organization->createAdmin();
        $user->join($organization);

        $user->setAdmin();
        return $user;
    }

    protected function createBasic($organization = null)
    {
        if (isset($organization)) {
            $user = factory(User::class)->create(['organization_id' => $organization->id]);
        } else {
            $user = factory(User::class)->create();
            $organization = $this->getOrganization($user);
        }
        $this->setSemester($organization);

        $organization->createBasicUser();
        $user->join($organization);

        $user->setBasicUser();
        return $user;
    }


    protected function getRole($role)
    {
        return factory(Role::class)->state($role)->create();
    }

    protected function createRole($name)
    {
        $role = $this->getRole($name);
        $user = factory(User::class)->create();
        $organization = $this->getOrganization($user);
        $organization->createBasicUser();
        $user->join($organization);

        $user->setRole($role);
        $this->setSemester($organization);

        return $user;
    }

    protected function loginAs($name, $organization = null)
    {
        if (strtolower($name) === 'admin') {
            $role = $this->createAdmin($organization);
        } else if (strtolower($name) === 'basic_user') {
            $role = $this->createBasic($organization);
        } else {
            $role = $this->createRole($name);
        }

        $this->actingAs($role);
        return $role;
    }

    private function getOrganization(User $user)
    {
        return factory(Organization::class)->create(['owner_id' => $user->id]);
    }

    private function setSemester($organization)
    {
        if (Semester::all()->isEmpty()) {
            factory(Semester::class)->create(['organization_id' => $organization->id]);
        }
    }
}
