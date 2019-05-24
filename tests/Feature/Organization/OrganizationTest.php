<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Organization;
use DB;

class OrganizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function registerUser(){
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);
        return $response;
    }
    public function test_get_createOrganization_page()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response->assertRedirect('/organization');
        $response = $this->get('/organization/create');
        $response->assertStatus(200);
    }

    public function test_create_Organization()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);
        $dbUser =  DB::table('users')->where('email', $user->email)->first();

        $response->assertRedirect('/organization');
        $response = $this->get('/organization/create');

        $org = factory(Organization::class)->make();

        $response = $this->post('/organization/',[
            'name' => $org->name
        ]);
        $this->assertDatabaseHas('organizations',[
            'name' => $org->name,
        ]);
        $response->assertRedirect('/role');

    }
    
    public function test_join_Organization()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();
        $org = factory(Organization::class)->create();

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);
        $dbUser =  DB::table('users')->where('email', $user->email)->first();

        $response->assertRedirect('/organization');

        $response = $this->post('/user/'.$dbUser->id.'/join',[
            'organization' => $org->id,
        ]);

        $this->assertDatabaseHas('users',[
            'email' => $user->email,
            'organization_id' => $org->id,
        ]);
        $response->assertRedirect('/dash');
    }
}
