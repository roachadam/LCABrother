<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $attributes = request()->validate([
            'zeta_number' => ['max:255'],
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255',],
            'major' => ['required', 'string', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed'],
            'phone' => ['phone'],
        ]);

        if (isset($attributes['phone'])) {
            $attributes['phone'] = $this->formatPhoneNumber($attributes['phone']);
        }

        $user = auth()->user();

        if ($user['email'] !== $attributes['email']) {
            $user['zeta_number'] = $attributes['zeta_number'];
            $user['name'] = $attributes['name'];
            $user['email'] = $attributes['email'];
            $user['phone'] = $attributes['phone'];
            $user['major'] = $attributes['major'];
            $user['email_verified_at'] = null;
            $user->save();
            auth()->user()->sendEmailVerificationNotification();
        } else {
            $user->update($attributes);
        }

        NotificationFunctions::alert('success', 'Updated your details!');
        return redirect('/users/profile');
    }

    public function create_avatar()
    {
        $user = auth()->user();
        return view('user.avatar', compact('user', $user));
    }

    public function update_avatar(Request $request)
    {
        $attributes = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'test' => 'boolean'
        ]);

        $user = auth()->user();

        $avatarName = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

        if (isset($attributes['test']) ? !$attributes['test'] : true) {
            $request->avatar->storeAs('avatars', $avatarName);
        }

        $user->avatar = $avatarName;
        $user->save();

        return back();
    }

    public function default_avatar(Request $request)
    {
        $user = auth()->user();
        $user->avatar = 'user.jpg';
        $user->save();
        return back();
    }

    public function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+' . $countryCode . ' (' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        }
        return $phoneNumber;
    }
}
