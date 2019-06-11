<?php

namespace App\Http\Controllers;

use App\InvolvementLog;
use Illuminate\Http\Request;
use DB;
use App\Involvement;
use App\User;

class InvolvementLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ManageInvolvement');
        $this->middleware('orgverified');
    }

    public function index()
    {
        $users = auth()->user()->organization->getVerifiedMembers();
        return view('involvementLogs.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $attributes = request()->validate([
            'involvement_id' => 'required',
            'usersInvolved' => ['required' , 'array'],
            'date_of_event' => 'required'
        ]);
        $involvement = Involvement::find($attributes['involvement_id']);
        //$date = '2019-05-31 14:05:39';

        foreach($attributes['usersInvolved'] as $user_id){
            $user = User::find($user_id);
            $user->addInvolvementLog($involvement, $attributes['date_of_event']);
        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvolvementLog  $involvementLog
     * @return \Illuminate\Http\Response
     */
    public function show(InvolvementLog $involvementLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvolvementLog  $involvementLog
     * @return \Illuminate\Http\Response
     */
    public function edit(InvolvementLog $involvementLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvolvementLog  $involvementLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvolvementLog $involvementLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvolvementLog  $involvementLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvolvementLog $involvementLog)
    {
        $involvementLog->delete();
        return back();
    }

    public function breakdown(Request $request, User $user){
        $logs = $user->InvolvementLogs;

        return view('involvementLogs.breakdown', compact('logs'));
    }
}
