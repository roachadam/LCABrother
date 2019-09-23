<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\Mail\MemberJoined;
use App\Organization;
use App\User;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberView')->only(['index', 'adminView']);
        $this->middleware('ManageMembers')->only('destroy');
        $this->middleware('orgverified')->only(['index', 'contact']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = auth()->user()->organization->users()->where('organization_verified', 1)->get();
        return view('user.userInfo.members', compact('members'));
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->id === 1 || auth()->user()->id === 4, 403);

        $user->delete();
        NotificationFunctions::alert('success', 'Successfully deleted user!');
        return redirect('/');
    }

    public function joinOrg(Request $request, User $user)
    {
        $attributes = $request->validate([
            'organization' => 'required'
        ]);

        $orgID = $attributes['organization'];

        $user->join($orgID);

        $user->setBasicUser();
        $org = Organization::find($orgID);

        Mail::to($org->owner->email)->send(
            new MemberJoined($user, $org)
        );

        return redirect('/dash');
    }

    public function adminView(Request $request, User $user)
    {
        return View('user.adminView', compact('user'));
    }
}
