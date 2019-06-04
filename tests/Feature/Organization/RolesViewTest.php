<?php

namespace Tests\Feature;

use App\Role;
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
    public function test_can_add_role(){
        $this->loginAsAdmin();
        $role = factory(Role::class)->raw();

        $this->post('/organizations/'.auth()->user()->organization->id.'/roles',[
            "name" => $role['name'],
            "manage_member_details" => "on",
            "manage_all_involvement" => "on",
        ]);


        $this->assertDatabaseHas('roles',[
            "name" => $role['name'],
        ]);

        $newRole = Role::where('name', $role['name'])->first();
        $permission_id = $newRole->permission_id;

        // $roles = Role::all();
        // dump($roles);
        // $this->assertDatabaseHas('permissions',[
        //     "id" => $permission_id,
        //     'manage_member_details' => '1',
        //     'manage_all_involvement' => '1',
        // ]);
    }
}
