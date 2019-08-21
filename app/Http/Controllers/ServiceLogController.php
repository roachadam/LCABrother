<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\ServiceLog;
use Illuminate\Http\Request;
use App\User;

class ServiceLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageService')->only(['edit', 'update', 'destroy']);
    }

    public function index()
    {
        $users = auth()->user()->organization->getVerifiedMembers();
        return view('service.serviceLogs.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceLog  $serviceLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceLog $serviceLog)
    {
        $this->authorize('update', $serviceLog);
        return view('service.serviceLogs.edit', compact('serviceLog'));
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
        $this->authorize('update', $serviceLog);
        $attributes = $request->all();
        $serviceLog->update($attributes);

        return redirect(route('serviceLogs.breakdown', $serviceLog->user));
    }

    public function breakdown(User $user)
    {
        $this->authorize('breakdown', [ServiceLog::class, $user]);
        $serviceLogs = $user->getActiveServiceLogs();
        return view('service.serviceLogs.breakdown', compact('serviceLogs', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceLog  $serviceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceLog $serviceLog)
    {
        $this->authorize('update', $serviceLog);
        $serviceLog->delete();
        NotificationFunctions::alert('success', 'Successfully deleted Service Log!');
        return redirect(route('serviceLogs.breakdown', $serviceLog->user));
    }
}
