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
     * Tests if the method User::findByName() correctly works
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
     * Tests if the method User::findById() correctly works
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
     * Tests if the method User::findAll() correctly works
     */
    public function test_can_find_all_users_in_organization()
    {
        $organizationId = 50;
        $createdUsers = factory(User::class, 5)->create(['organization_id' => $organizationId]);

        $foundUsers = User::findAll($organizationId);

        $this->assertTrue(count($foundUsers->diff($createdUsers)) === 0);
    }
}
