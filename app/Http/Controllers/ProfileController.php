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
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255',],
            'password' => ['string', 'min:8', 'confirmed'],
            'phone' => ['phone'],
        ]);

        $user = auth()->user();

        if ($user['email'] !== $attributes['email']) {
            $user['email'] = $attributes['email'];
            $user['phone'] = $attributes['phone'];
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
        // Since this step can be ignored, we should mark it as completed once shown

        if(session('regStep') == null){
            session(['regStep' => 0]); // Mark registration step as completed
            session()->save();
        }


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


        return redirect('/organization');
    }

    public function default_avatar(Request $request)
    {
        $user = auth()->user();
        $user->avatar = 'user.jpg';
        $user->save();
        return back();
    }
}
