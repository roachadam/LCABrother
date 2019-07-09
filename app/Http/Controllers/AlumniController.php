<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use App\Mail\AlumniContact;
use Illuminate\Http\Request;

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
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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
                if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
                    sleep(5); //use usleep(500000) for half a second or less
                }
            }
        } else {
            foreach ($attributes['alum'] as $alum) {
                $alumni = User::find($alum);
                if (isset($alumni)) {
                    Mail::to($alumni->email)->send(
                        new AlumniContact($org, $attributes['subject'], $attributes['body'])
                    );
                    if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
                        sleep(5); //use usleep(500000) for half a second or less
                    }
                }
            }
        }

        return back();
    }
}
