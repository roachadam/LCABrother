<?php

namespace App\Http\Controllers;

use App\ServiceLog;
use Illuminate\Http\Request;

class ServiceLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('orgverified');
        $this->middleware('ManageService');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceLog  $serviceLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceLog $serviceLog)
    {
        return view('service.logEdit', compact('serviceLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceLog  $serviceLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceLog $serviceLog)
    {
        $attributes = $request->all();
        $serviceLog->update($attributes);

        return redirect()->action('UserController@serviceBreakdown', ['user' => $serviceLog->user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceLog  $serviceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceLog $serviceLog)
    {
        $serviceLog->delete();
        return redirect()->action('UserController@serviceBreakdown', ['user' => $serviceLog->user]);
    }
}
