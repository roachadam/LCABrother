<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class OrgVerificationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    // hits from rout /orgpending
    public function index(){

        // if(Auth::user()->organization_verified == 1){
        //     return redirect('/dash');
        // }
        return view('orgpending.waitingScreen');
    }

    public function show(User $user){
        return view('orgPending.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $approved = request()->has('organization_verified');
        if($approved)
        {
            $attributes = ['organization_verified' => $approved];
        }
        else
        {

            $attributes = [
            'organization_verified' => $approved,
            'organization_id' => null
            ];
        }
        $user->update($attributes);
        return redirect('/dash');
    }
    public function rejected(){
        return view('orgPending.rejected');
    }
    public function waiting(){
        return view('orgPending.waiting');
    }
}
