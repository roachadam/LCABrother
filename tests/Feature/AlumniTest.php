<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class AlumniTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * AlumniController@index
     * Testing ability to view alumni page
     */
    public function test_get_alumni_page()
    {
        $user = $this->loginAs('alumni_manager');

        $alumni = factory(User::class, 3)->create([
            'organization_id' => $user->organization_id,
            'organization_verified' => 2,
        ]);

        $response = $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('alumni.index'))
            ->assertSuccessful()
            ->assertSee('Alumni');

        foreach ($alumni as $alum) {
            $response
                ->assertSee($alum->name)
                ->assertSee($alum->phone)
                ->assertSee($alum->email)
                ->assertSee($alum->updated_at);
        }
    }

    //TODO: AlumniController@destroy, AlumniController@send

    /**
     * * AlumniController@setAlum
     * Testing ability to set a member to alumni status
     */
    public function test_set_user_to_alumni()
    {
        $user = $this->loginAs('alumni_manager');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('alumni.setAlum', $user))
            ->assertSuccessful()
            ->assertSee('Successfully marked ' . $user->name . ' as Alumni!')
            ->assertSee('Alumni')
            ->assertSee($user->name);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'organization_verified' => 2,
        ]);
    }

    /**
     * * AlumniController@contact
     * Testing ability to view the contact page
     */
    public function test_get_contact_page()
    {
        $user = $this->loginAs('alumni_manager');
        $alumni = factory(User::class)->create([
            'organization_id' => $user->organization_id,
            'organization_verified' => 2
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('alumni.contact'))
            ->assertSuccessful()
            ->assertSee('Alumni To Contact')
            ->assertSee($alumni->name);
    }
}
