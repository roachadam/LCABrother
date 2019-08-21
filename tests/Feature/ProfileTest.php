<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\InvolvementLog;
use Tests\TestCase;
use App\ServiceLog;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * ProfileController@index
     * Testing ability to view a user's profile
     */
    public function test_can_view_profile()
    {
        $user = $this->loginAs('basic_user');

        factory(InvolvementLog::class, 5)->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
        ]);

        factory(ServiceLog::class, 5)->create([
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('profile.index'))
            ->assertSuccessful()
            ->assertSee('Your Details')
            ->assertSee($user->name)
            ->assertSee($user->phone)
            ->assertSee($user->email)
            ->assertSee('Hours Logged: ' . $user->getServiceHours())
            ->assertSee('Money Donated: ' . $user->getMoneyDonated())
            ->assertSee('Points Logged: ' . $user->getInvolvementPoints());
    }

    /**
     * * ProfileController@edit
     * Testing ability to view a user's profile
     */
    public function test_can_get_edit_profile_view()
    {
        $user = $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('profile.index'))
            ->get(route('profile.edit'))
            ->assertSuccessful()
            ->assertSee($user->phone)
            ->assertSee($user->email)
            ->assertSee('Edit Your Avatar');
    }

    /**
     * * ProfileController@update
     * Testing ability to update the user's email
     */
    public function test_user_can_edit_email()
    {
        $user = $this->loginAs('basic_user');

        $originalEmail = $user->email;
        $newEmail = 'johndoe@gmail.com';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('profile.update'), [
                'email' => $newEmail,
                'phone' => '12224567890',
            ])
            ->assertSuccessful()
            ->assertSee('Updated your details!')
            ->assertSee('Verify Your Email Address');

        $this->assertNotEquals($originalEmail, $user->email);
        $this->assertEquals($newEmail, $user->email);

        $this->assertDatabaseHas('users', [
            'email' => $newEmail,
            'phone' => $user->phone,
            'id' => $user->id,
        ]);
    }

    /**
     * * ProfileController@update
     * Testing ability to update the user's phone number
     */
    public function test_user_can_edit_phone()
    {
        $user = $this->loginAs('basic_user');

        $originalPhone = $user->phone;
        $newPhone = '12224567890';

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('profile.update'), [
                'email' => $user->email,
                'phone' => $newPhone,
            ])
            ->assertSuccessful()
            ->assertSee('Updated your details!')
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->phone);

        $this->assertNotEquals($originalPhone, $user->phone);
        $this->assertEquals($newPhone, $user->phone);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'phone' => $newPhone,
            'id' => $user->id,
        ]);
    }

    /**
     * * ProfileController@create_avatar
     * Testing testing ability to get the create avatar view
     */
    public function test_get_create_avatar_view()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('profile.createAvatar'))
            ->assertSuccessful()
            ->assertSee('Add Avatar');
    }

    /**
     * * ProfileController@update_avatar
     * Testing ability to update the user's avatar
     */
    public function test_upload_custom_avatar()
    {
        $user = $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('profile.createAvatar'))
            ->post(route('profile.updateAvatar'),  [
                'avatar' => new UploadedFile('storage\app\public\avatars\test_profile_picture.jpg', 'test_profile_picture.jpg', 'jpeg', null, true),
                'test' => true,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => $user->id . '_avatar' . time() . '.jpg',
        ]);
    }

    /**
     * * ProfileController@default_avatar
     * Testing ability to reset the user's avatar to default
     */
    public function test_make_avatar_default()
    {
        $user = $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('profile.edit'))
            ->post(route('profile.defaultAvatar'))
            ->assertSuccessful()
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => 'user.jpg'
        ]);
    }
}
