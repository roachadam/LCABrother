<?php

namespace App\Http\Controllers;

use App\InvolvementLog;
use Illuminate\Http\Request;
use App\Commons\NotificationFunctions;
use DB;
use App\Involvement;
use App\User;

class InvolvementLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageInvolvement')->except(['index', 'breakdown']);
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
            'involvement_id' => 'required',
            'usersInvolved' => ['required', 'array'],
            'date_of_event' => 'required'
        ]);
        $involvement = Involvement::find($attributes['involvement_id']);

        foreach ($attributes['usersInvolved'] as $user_id) {
            $user = User::find($user_id);
            $user->addInvolvementLog($involvement, $attributes['date_of_event']);
        }

        NotificationFunctions::alert('success', 'Involvement points were logged!');

        return redirect(route('involvement.index'));
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
        NotificationFunctions::alert('danger', 'Involvement log(s) deleted!');
        return back();
    }

    public function breakdown(Request $request, User $user)
    {
        $logs = $user->InvolvementLogs;

        return view('involvement.involvementLogs.breakdown', compact('logs'));
    }
}
