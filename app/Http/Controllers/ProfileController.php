<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Auth;

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
        return redirect((strpos(session()->previousUrl(''), '/users/contact') !== false) ? route('contact.users') : route('profile.index'));
    }

    public function create_avatar()
    {
        $user = auth()->user();
        return view('user.avatar', compact('user', $user));
    }

    public function update_avatar(Request $request)
    {
        $attributes = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $user = Auth::user();
        if ($request->hasFile('avatar')) {

            //get filename with extension
            $ogFileName = $request->file('avatar')->getClientOriginalName();

            //get filename without extension
            $ogFileName = pathinfo($ogFileName, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('avatar')->getClientOriginalExtension();

            //filename to store
            $fileName = $ogFileName . '_' . time() . '.' . $extension;

            //Upload File to s3
            Storage::disk('s3')->put('avatars/' . $fileName, fopen($request->file('avatar'), 'r+'), 'public');

            // Delete old avatar to save space
            if ($user->avatar != 'user.jpg')
                Storage::disk('s3')->delete('avatars/' . $user->avatar);

            $user->avatar = $fileName;
            $user->save();
            return back();
        }


        return back();
    }

    public function default_avatar(Request $request)
    {

        $user = auth()->user();

        if ($user->avatar != 'user.jpg')
            Storage::disk('s3')->delete('avatars/' . $user->avatar);

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
