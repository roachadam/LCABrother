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
        $this->middleware('MemberView', ['only' => ['index']]);
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

    public function destroy(User $user)
    {
        abort_if($user->id != auth()->id(), 403);
        $user->delete();
        return redirect('/');
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

    public function orgRemove(Request $request, User $user)
    {
        $user->organization_verified = 0;
        $user->save();

        return back();
    }

    public function adminView(Request $request, User $user)
    {
        return View('user.adminView', compact('user'));
    }
}
