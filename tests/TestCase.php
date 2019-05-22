<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Organization;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAdminRole(){
        $adminRole = factory(Role::class)->states('admin')->create();;
        return $adminRole;
    }
    protected function getBasicRole(){
        $role = factory(Role::class)->states('basic_user')->create();;
        return $role;
    }
    protected function getMemberManagerRole(){
        $role = factory(Role::class)->states('manage_members')->create();;
        return $role;
    }
    protected function getServiceManagerRole(){
        $role = factory(Role::class)->states('manage_service')->create();;
        return $role;
    }
    protected function getInvolvementManagerRole(){
        $role = factory(Role::class)->states('manage_involvement')->create();;
        return $role;
    }

    protected function getViewMemberRole(){
        $role = factory(Role::class)->states('view_members')->create();;
        return $role;
    }
    protected function getViewServiceRole(){
        $role = factory(Role::class)->states('view_service')->create();;
        return $role;
    }
    protected function getViewInvolvementRole(){
        $role = factory(Role::class)->states('view_involvement')->create();;
        return $role;
    }
    protected function getLogServiceRole(){
        $role = factory(Role::class)->states('log_service')->create();;
        return $role;
    }



    protected function getOrganization(){
        $org = factory(Organization::class)->create();
        return $org;
    }

    //creates the users with the desired roles

    protected function createAdmin(array $attributes = []){
        //$adminRole = $this->getAdminRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createAdmin();
        $user->join($org);

        $user->setAdmin();
        return $user;
    }
    protected function createBasic(array $attributes = []){
        //$adminRole = $this->getAdminRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setAdmin();
        return $user;
    }
    protected function createMemManager(array $attributes = []){
        $role = $this->getMemberManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createInvolvementManager(array $attributes = []){
        $role = $this->getInvolvementManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createServiceManager(array $attributes = []){
        $role = $this->getServiceManagerRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createMemberViewer(array $attributes = []){
        $role = $this->getViewMemberRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createServiceViewer(array $attributes = []){
        $role = $this->getViewServiceRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createInvolvementViewer(array $attributes = []){
        $role = $this->getViewInvolvementRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }
    protected function createServiceLogger(array $attributes = []){
        $role = $this->getLogServiceRole();
        $user = factory(User::class)->create();
        $org = $this->getOrganization();
        $org->createBasicUser();
        $user->join($org);

        $user->setRole($role);
        return $user;
    }

    //logs in as the selected users
    protected function loginAsAdmin($admin = false){
        if (! $admin) {
            $admin = $this->createAdmin();
        }
        $this->actingAs($admin);
        return $admin;
    }
    protected function loginAsBasic($basic = false){
        if (! $basic) {
            $basic = $this->createBasic();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsMemberManager($basic = false){
        if (! $basic) {
            $basic = $this->createMemManager();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsInvolvementManager($basic = false){
        if (! $basic) {
            $basic = $this->createInvolvementManager();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsServiceManager($basic = false){
        if (! $basic) {
            $basic = $this->createServiceManager();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsMemberViewer($basic = false){
        if (! $basic) {
            $basic = $this->createMemberViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsServiceViewer($basic = false){
        if (! $basic) {
            $basic = $this->createServiceViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsInvolvementViewer($basic = false){
        if (! $basic) {
            $basic = $this->createInvolvementViewer();
        }
        $this->actingAs($basic);
        return $basic;
    }
    protected function loginAsServiceLogger($basic = false){
        if (! $basic) {
            $basic = $this->createServiceLogger();
        }
        $this->actingAs($basic);
        return $basic;
    }
}
