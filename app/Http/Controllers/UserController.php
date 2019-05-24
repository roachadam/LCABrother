<?php

namespace App\Http\Controllers;

use Auth;
use CheckHasRole;
use App\User;
use App\Organization;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('MemberView');
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
        $members = $org->users()->where('organization_verified',1)->get();
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
        //
    }


    public function update(Request $request, User $user)
    {
        // Make sure they don't try to edit the user id and change someone elses organization
        // if(Auth::id() != $user->id){
        //     abort();
        // }
        abort(403);
    }


    public function destroy(User $user)
    {
        //
    }

    public function contact(){
        $org = auth()->user()->organization;
        $members = $org->getVerifiedMembers();
        return view('highzeta.contact', compact('members'));
    }

    public function joinOrg(Request $request, User $user){

        abort_unless(Auth::id() == $user->id,403);

        $org = $request->organization;
        $user->join($org);

        $user->setBasicUser();

        return redirect('/dash');
    }

}
