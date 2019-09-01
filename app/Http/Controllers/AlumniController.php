<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\Mail\AlumniContact;
use App\User;
use Mail;

class AlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageAlumni');
    }

    public function index()
    {
        $alumni = auth()->user()->organization->alumni;
        return view('alumni.index', compact('alumni'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        dd('here');
    }

    public function setAlum(User $user)
    {
        $user->markAsAlumni();
        NotificationFunctions::alert('success', 'Successfully marked ' . $user->name . ' as Alumni!');
        return redirect('/alumni');
    }

    public function contact()
    {
        $alumni = auth()->user()->organization->alumni;
        return view('alumni.contact', compact('alumni'));
    }

    public function send(Request $request)
    {
        $attributes = $request->validate([
            'alum' => 'required',
            'subject' => 'required',
            'body' => 'required'
        ]);
        $org = auth()->user()->organization;
        if ($attributes['alum'][0] == 0) {
            $alumnis = auth()->user()->organization->alumni;
            foreach ($alumnis as $alumni) {
                Mail::to($alumni->email)->send(
                    new AlumniContact($org, $attributes['subject'], $attributes['body'])
                );
            }
        } else {
            foreach ($attributes['alum'] as $alum) {
                $alumni = User::find($alum);
                if (isset($alumni)) {
                    Mail::to($alumni->email)->send(
                        new AlumniContact($org, $attributes['subject'], $attributes['body'])
                    );
                }
            }
        }

        return back();
    }
}
