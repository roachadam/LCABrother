<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Organization;
use App\User;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageMembers')->only('removeUser');
    }

    public function index()
    {
        $orgs = Organization::all();
        return view('organizations.index', compact('orgs'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'min: 3', 'max:255'],
        ]);
        $user = Auth::user();
        $org = Organization::create($attributes);

        $org->owner()->associate($user)->save();
        $user->organization()->associate($org)->save();

        $org->createAdmin();
        $org->createBasicUser();
        $user->setAdmin();
        $org->setCalendarCategories();
        $user->setVerification(true);
        return redirect('/goals/create');
    }

    public function removeUser(Request $request, User $user)
    {
        $user->organization_verified = 0;
        $user->save();

        NotificationFunctions::alert('success', 'Successfully Removed ' . $user->name . ' from Organization!');
        return redirect(route('user.index'));
    }
    public function changeOwner(Request $request, Organization $organization, User $user){
        $organization->owner_id = $user->id;
        $organization->save();

        NotificationFunctions::alert('success', 'Successfully Made ' . $user->name . ' the owner of ' . $organization->name . '.');
        return back();
    }
}
