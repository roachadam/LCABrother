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
    use RefreshDatabase;

    public function test_can_register_user()
    {
        $user = factory(User::class)->make();
        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post('/register', [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => 'secret123!=-',
                'password_confirmation' => 'secret123!=-'
            ])
            ->assertSuccessful()
            ->assertSee('Add Avatar');
    }

    public function test_get_create_organization_page()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => 'secret123!=-',
            'password_confirmation' => 'secret123!=-'
        ]);

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
            'password' => 'secret123!=-',
            'password_confirmation' => 'secret123!=-'
        ]);
        $dbUser =  DB::table('users')->where('email', $user->email)->first();

        $response = $this->get('/organization/create');

        $org = factory(Organization::class)->make();

        $response = $this->post('/organization/', [
            'name' => $org->name
        ]);
        $this->assertDatabaseHas('organizations', [
            'name' => $org->name,
        ]);
        $response->assertRedirect('/goals/create');
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
            'password' => 'secret123!=-',
            'password_confirmation' => 'secret123!=-'
        ]);
        $dbUser =  DB::table('users')->where('email', $user->email)->first();


        $response = $this->post('/user/' . $dbUser->id . '/join', [
            'organization' => $org->id,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'organization_id' => $org->id,
        ]);
        $response->assertRedirect('/dash');
    }
}
