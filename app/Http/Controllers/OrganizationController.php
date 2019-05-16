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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $orgs =  Organization::all();
        return view('organizations.index', compact('orgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required','min: 3', 'max:255'],
        ]);
        $user = Auth::user();
        $org = Organization::create($attributes);

        //Dawson Edit - cant test at work
        //We wernt using the elquent relationships the way we should have been, if you check the migrations
        //I made the relationship more verbose to laravel,so we should be able to do the below
        $user->organization()->associate($org)->save(); //https://gist.github.com/avataru/35c77721ec37b70df1d345b19ba0e2a6
        $org->owner()->save($user);

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
