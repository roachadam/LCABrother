<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserUnitTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Tests if the method User::findByName($organizationId) correctly returns
     * user in organization with matching name
     */
    public function test_can_find_users_in_organization_by_name()
    {
        $fakeName = 'janedoe';
        $createdUser = factory(User::class)->create(['name' => $fakeName]);

        $foundUser = User::findByName($fakeName, $createdUser->organization_id);

        $this->assertEquals($createdUser->id, $foundUser->id);
        $this->assertEquals($fakeName, $foundUser->name);
    }

    /**
     * Tests if the method User::findByName() correctly returns first user
     * with matching name
     */
    public function test_can_find_users_by_name()
    {
        $fakeName = 'janedoe';
        $createdUser = factory(User::class)->create(['name' => $fakeName]);

        $foundUser = User::findByName($fakeName);

        $this->assertEquals($createdUser->id, $foundUser->id);
        $this->assertEquals($fakeName, $foundUser->name);
    }

    /**
     * Tests if the method User::findById($organizationId) correctly returns
     * user in organization with matching Id
     */
    public function test_can_find_users_in_organization_by_id()
    {
        $fakeId = 56;
        $createdUser = factory(User::class)->create(['id' => $fakeId]);

        $foundUser = User::findById($fakeId, $createdUser->organization_id);

        $this->assertEquals($createdUser->name, $foundUser->name);
        $this->assertEquals($fakeId, $foundUser->id);
    }

    /**
     * Tests if the method User::findById() correctly returns first user
     * with matching Id
     */
    public function test_can_find_users_by_id()
    {
        $fakeId = 56;
        $createdUser = factory(User::class)->create(['id' => $fakeId]);

        $foundUser = User::findById($fakeId);

        $this->assertEquals($createdUser->name, $foundUser->name);
        $this->assertEquals($fakeId, $foundUser->id);
    }

    /**
     * Tests if the method User::findAll($organizationId) correctly returns
     * all users in the organization
     */
    public function test_can_find_all_users_in_organization()
    {
        $organizationId = 50;
        $createdUsers = factory(User::class, 5)->create(['organization_id' => $organizationId]);

        $foundUsers = User::findAll($organizationId);

        $this->assertTrue(count($foundUsers->diff($createdUsers)) === 0);
    }

    /**
     * Tests if the method User::findAll() correctly returns all users
     */
    public function test_can_find_all_users()
    {
        $createdUsers = factory(User::class, 5)->create();

        $foundUsers = User::findAll();

        $this->assertTrue(count($foundUsers->diff($createdUsers)) === 0);
    }
}
