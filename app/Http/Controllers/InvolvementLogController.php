<?php

namespace App\Http\Controllers;

use App\InvolvementLog;
use Illuminate\Http\Request;
use DB;


class InvolvementLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ManageInvolvement');
    }

    public function index()
    {
        //Need to really think about a way to sum each of the same brothers stuff without just a
        //big nested loop
        $org = auth()->user()->organization;
        $involvement = $org->involvement;
        $logs = DB::table('users')
                    ->join('involvement_logs', 'users.id','=','involvement_logs.user_id')
                    ->join('involvements', 'involvements.id', '=', 'involvement_logs.involvement_id')
                    ->select(DB::raw('users.id , users.name , involvements.name as event_name , SUM(involvement_logs.points) as points'))
                    ->groupBy('users.id', 'users.name', 'event_name')
                    ->get();
        return view('involvementLogs.index', compact('logs'));
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
        //
    }
}
