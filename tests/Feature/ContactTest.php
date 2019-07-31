<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * ContactController@userContacts
     * Testing the ability to view all user's contacts
     */
    public function test_view_all_users_contact_page()
    {
        $user = $this->loginAs('basic_user');
        $users = factory(User::class, 5)->create(['organization_id' => $user->organization_id])->push($user);

        $response = $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->get(route('contact.users'))
            ->assertSuccessful();

        foreach ($users as $user) {
            $response
                ->assertSee($user->name)
                ->assertSee($user->email)
                ->assertSee($user->phone);
        }
    }
}
