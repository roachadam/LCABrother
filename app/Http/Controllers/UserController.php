<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MemberJoined;
use App\Organization;
use App\User;
use Auth;
use Mail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('MemberView', ['only' => ['index', 'contact']]);
        $this->middleware('orgverified', ['only' => ['index', 'contact']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $org = Auth::user()->organization;
        $members = $org->users()->where('organization_verified', 1)->get();
        return view('user.userInfo.members', compact('members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
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
            Auth::user()->sendEmailVerificationNotification();
        } else {
            $user->update($attributes);
        }

        return redirect('/users/profile');
    }

    public function destroy(User $user)
    {
        abort_if($user->id != auth()->id(), 403);
        $user->delete();
        return redirect('/');
    }

    public function contact()
    {
        $org = auth()->user()->organization;
        $members = $org->getVerifiedMembers();
        return view('user.userInfo.contact', compact('members'));
    }

    public function joinOrg(Request $request, User $user)
    {

        abort_unless(Auth::id() == $user->id, 403);

        $orgID = $request->organization;
        $user->join($orgID);

        $user->setBasicUser();
        $org =  Organization::find($orgID);

        Mail::to($org->owner->email)->send(
            new MemberJoined($user, $org)
        );

        return redirect('/dash');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function create_avatar()
    {
        $user = Auth::user();
        return view('user.avatar', compact('user', $user));
    }

    public function update_avatar(Request $request)
    {

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $avatarName = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('avatars', $avatarName);

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

    public function adminView(Request $request, User $user)
    {
        return View('user.adminView', compact('user'));
    }

    public function orgRemove(Request $request, User $user)
    {
        $user->organization_verified = 0;
        $user->save();

        return back();
    }

    public function serviceBreakdown(User $user)
    {
        $serviceLogs = $user->getActiveServiceLogs();
        return view('service.userBreakdown', compact('serviceLogs', 'user'));
    }
}
