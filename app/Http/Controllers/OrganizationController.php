<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Organization;
use App\User;

class OrganizationController extends Controller
{
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
        $user->setVerification(true);
        return redirect('/goals/create');
    }

    public function orgRemove(Request $request, User $user)
    {
        $user->organization_verified = 0;
        $user->save();

        return back();
    }
}
