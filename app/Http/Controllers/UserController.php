<?php

namespace App\Http\Controllers;

use Auth;
use CheckHasRole;
use App\User;
use App\Organization;
use Illuminate\Http\Request;
use App\Mail\MemberJoined;
use Mail;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('MemberView', ['only' => ['index', 'contact']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$organization = auth()->user()->organization()->get();
        //$users = $organization->users();
        $org = Auth::user()->organization;
        $members = $org->users()->where('organization_verified', 1)->get();
        return view('highzeta.members', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
        // Make sure they don't try to edit the user id and change someone elses organization
        // if(Auth::id() != $user->id){
        //     abort();
        // }
        //dump($request);
        //abort(403);
        $attributes = request()->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255',],
            'password' => ['string', 'min:8', 'confirmed'],
            'phone' => ['phone'],
        ]);
        $user = auth()->user();

        $user->update($attributes);

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
        return view('highzeta.contact', compact('members'));
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
}
