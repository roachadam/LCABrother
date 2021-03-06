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
    public function __construct()
    {
        $this->middleware('orgverified')->only('show');
        $this->middleware('ManageMembers')->only('approve');
    }

    // hits from rout /orgpending
    public function index()
    {

        // if(Auth::user()->organization_verified == 1){
        //     return redirect('/dash');
        // }
        return view('orgpending.waitingScreen');
    }

    public function approve(User $user)
    {
        return view('orgPending.approve', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $isApproved = request()->has('organization_verified');
        if ($isApproved) {
            event(new UserValidated($user));

            Mail::to($user->email)->send(
                new OrgVerified($user)
            );
            $user->setVerification($isApproved);
            $user->checkAcademicRecords();
        } else {
            event(new MemberDeclined($user));
            Mail::to($user->email)->send(
                new OrgDenied($user)
            );
            $user->setVerification($isApproved);
        }
        return redirect('/dash');
    }

    public function rejected()
    {
        return view('orgPending.rejected');
    }

    public function waiting()
    {
        if (auth()->user()->isVerified()) {
            return redirect('/dash');
        }
        return view('orgPending.waiting');
    }

    public function alumni()
    {
        return view('orgPending.alumni');
    }
}
