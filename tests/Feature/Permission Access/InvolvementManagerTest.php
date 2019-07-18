<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvolvementManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_InvolvementManager_can_visit_dash()
    {
        $this->loginAsInvolvementManager();

        $response = $this->get('/dash');
        $response->assertStatus(200);
    }

    //@TODO: Figure out why this doesn't work
    // public function test_InvolvementManager_can_visit_Involvement()
    // {
    //     $this->loginAsInvolvementManager();

    //     $this
    //         ->withExceptionHandling()
    //         ->followingRedirects()
    //         ->get(route('involvement.index'))
    //         ->assertSuccessful();
    // }

    /**
     * Testing ability for involvement manager to view involvement events page
     */
    public function test_InvolvementManager_can_visit_Involvement_Events()
    {
        $this->loginAsInvolvementManager();

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->get(route('involvement.adminView'))
            ->assertSuccessful()
            ->assertSee('Involvement Events')
            ->assertSee('Create New');
    }

    public function test_InvolvementManager_cannot_visit_user()
    {
        $this->loginAsInvolvementManager();
        $response = $this->get('/user');
        $response->assertRedirect('/dash');
    }

    public function test_InvolvementManager_cannot_visit_role()
    {
        $this->loginAsInvolvementManager();
        $response = $this->get('/role');
        $response->assertRedirect('/dash');
    }

    public function test_basic_InvolvementManager_cannot_visit_userContact()
    {
        $this->loginAsInvolvementManager();
        $response = $this->get('/users/contact');
        $response->assertRedirect('/dash');
    }
}
