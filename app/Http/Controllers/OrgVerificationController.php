<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Mail;
use App\Mail\OrgVerified;
use App\User;
use App\Mail\OrgDenied;
use App\Notifications\AdminVerifiedUser;
use App\Events\UserValidated;
use App\Events\MemberDeclined;

class OrgVerificationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('orgverified', ['only' =>'show']);
        //$this->middleware('ManageMembers', ['only' =>'show']);

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
        if($approved){
            event(new UserValidated($user));

            Mail::to($user->email)->send(
                new OrgVerified($user)
            );
        }
        else{
            event(new MemberDeclined($user));
            Mail::to($user->email)->send(
                new OrgDenied($user)
            );
        }
        $user->setVerification($approved);

        return redirect('/dash');
    }
    public function rejected(){
        return view('orgPending.rejected');
    }
    public function waiting(){
        if(auth()->user()->isVerified()){
            return redirect('/dash');
        }
        return view('orgPending.waiting');
    }
    public function alumni(){
        return view('orgPending.alumni');
    }
}
