<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use Mail;
use App\Mail\JoinOrgInvitation;

class MassInvite extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageMembers');
    }


    public function index()
    {
        session(['regStep' => 5]); // Mark registration step as completed
        session()->save();

        return view('massInvite.index');
    }

    public function inviteAll(Request $request)
    {
        $org = auth()->user()->organization;

        $attributes = request()->validate([
            'emailList' => 'required',
        ]);
        $emailStr = $request->all()['emailList'];
        $emails = explode(',', $emailStr);
        foreach ($emails as $email) {
            $email = trim($email, " \t\n\r");
            Mail::to($email)->queue(
                new JoinOrgInvitation($org)
            );

        }

        return redirect('/dash');
    }
}
