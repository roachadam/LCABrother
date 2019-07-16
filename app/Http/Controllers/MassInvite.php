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
            //Extreme non production only, gets around email server request limit
            //need to move away from mailtrap for master
            if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
                sleep(5); //use usleep(500000) for half a second or less
            }
            // REMOVE IF ON MASTER
        }

        return redirect('/dash');
    }
}
