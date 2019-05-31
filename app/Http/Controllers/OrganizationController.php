<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Organization;
use App\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $orgs =  Organization::all();
        return view('organizations.index', compact('orgs'));
    }

    public function create()
    {

        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required','min: 3', 'max:255'],
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

    public function show(Organization $organization)
    {
        //
    }

    public function edit(Organization $organization)
    {
        //
    }

    public function update(Request $request, Organization $organization)
    {
        //
    }

    public function destroy(Organization $organization)
    {
        //
    }

}
