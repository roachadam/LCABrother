<?php

namespace Tests;

use App\Role;
use App\User;
use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Notification;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Organization;

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

    protected function getAdminRole()
    {
        $adminRole = factory(Role::class)->states('admin')->create();;
        return $adminRole;
    }

    protected function getBasicRole()
    {
        $role = factory(Role::class)->states('basic_user')->create();;
        return $role;
    }

    protected function getMemberManagerRole()
    {
        $role = factory(Role::class)->states('manage_members')->create();;
        return $role;
    }

    protected function getServiceManagerRole()
    {
        $role = factory(Role::class)->states('manage_service')->create();;
        return $role;
    }

    protected function getInvolvementManagerRole()
    {
        $role = factory(Role::class)->states('manage_involvement')->create();;
        return $role;
    }

    protected function getViewMemberRole()
    {
        $role = factory(Role::class)->states('view_members')->create();;
        return $role;
    }

    protected function getViewServiceRole()
    {
        $role = factory(Role::class)->states('view_service')->create();;
        return $role;
    }

    protected function getViewInvolvementRole()
    {
        $role = factory(Role::class)->states('view_involvement')->create();;
        return $role;
    }

    protected function getLogServiceRole()
    {
        $role = factory(Role::class)->states('log_service')->create();;
        return $role;
    }



    protected function getOrganization(User $user)
    {
        $org = factory(Organization::class)->create(['owner_id' => $user->id]);
        return $org;
    }

    //creates the users with the desired roles

    protected function createAdmin($organization = null)
    {
        //$adminRole = $this->getAdminRole();
        if ($organization !== null) {
            $user = factory(User::class)->create(['organization_id' => $organization->id]);
        } else {
            $user = factory(User::class)->create();
            $organization = $this->getOrganization($user);
        }
        $organization->createAdmin();
        $user->join($organization);

        $user->setAdmin();
        return $user;
    }

    protected function createBasic($organization = null)
    {
        //$adminRole = $this->getAdminRole();
        if ($organization !== null) {
            $user = factory(User::class)->create(['organization_id' => $organization->id]);
        } else {
            $user = factory(User::class)->create();
            $organization = $this->getOrganization($user);
        }
        $organization->createBasicUser();
        $user->join($organization);

        $user->setBasicUser();
        return $user;
    }

    protected function createMemManager(array $attributes = [])
    {
        $role = $this->getMemberManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createInvolvementManager(array $attributes = [])
    {
        $role = $this->getInvolvementManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createServiceManager(array $attributes = [])
    {
        $role = $this->getServiceManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createMemberViewer(array $attributes = [])
    {
        $role = $this->getViewMemberRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createServiceViewer(array $attributes = [])
    {
        $role = $this->getViewServiceRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createInvolvementViewer(array $attributes = [])
    {
        $role = $this->getViewInvolvementRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    protected function createServiceLogger(array $attributes = [])
    {
        $role = $this->getLogServiceRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization($user);
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    //logs in as the selected users
    protected function loginAsAdmin($organization = null)
    {

        $admin = $this->createAdmin($organization);

        $this->actingAs($admin);
        return $admin;
    }

    protected function loginAsBasic($organization = null)
    {
        $basic = $this->createBasic($organization);
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsMemberManager($basic = false)
    {
        if (!$basic) {
            $basic = $this->createMemManager();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsInvolvementManager($basic = false)
    {
        if (!$basic) {
            $basic = $this->createInvolvementManager();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsServiceManager($basic = false)
    {
        if (!$basic) {
            $basic = $this->createServiceManager();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsMemberViewer($basic = false)
    {
        if (!$basic) {
            $basic = $this->createMemberViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsServiceViewer($basic = false)
    {
        if (!$basic) {
            $basic = $this->createServiceViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsInvolvementViewer($basic = false)
    {
        if (!$basic) {
            $basic = $this->createInvolvementViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function loginAsServiceLogger($basic = false)
    {
        if (!$basic) {
            $basic = $this->createServiceLogger();
        }
        $this->actingAs($basic);
        return $basic;
    }

    protected function registerNewUser()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);
        $User =  DB::table('users')->where('email', $user->email)->first();
        $this->actingAs($User);
        return $User;
    }
}
