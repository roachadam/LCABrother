<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Organization;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * OrganizationController@index
     * Testing the ability to view the choose/create and organization page
     */
    public function test_get_choose_organization_page()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('organization.index'))
            ->assertSuccessful()
            ->assertSee('Join Organization')
            ->assertSee('Choose Your Organization');
    }

    /**
     * * OrganizationController@create
     * Testing the ability to get the create organization page
     */
    public function test_get_create_organization_page()
    {
        $this->loginAs('basic_user');

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->get(route('organization.create'))
            ->assertSee('Create Organization')
            ->assertSee('Name');
    }

    /**
     * * OrganizationController@store
     * Testing the ability to create a new organization
     */
    public function test_create_Organization()
    {
        $this->loginAs('basic_user');

        $organization = factory(Organization::class)->make();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('organization.create'))
            ->post(route('organization.store', ['name' => $organization->name]))
            ->assertSuccessful();

        $this->assertDatabaseHas('organizations', [
            'name' => $organization->name,
        ]);
    }
}
