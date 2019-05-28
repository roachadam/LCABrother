<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_roles_of_org()
    {
        $this->loginAsAdmin();
        $org = auth()->user()->organization;
        $roles = $org->roles;
        //dd($roles);
        foreach($roles as $role){
            $this->get('/role')->assertSee($role->name);
        }


    }
}
