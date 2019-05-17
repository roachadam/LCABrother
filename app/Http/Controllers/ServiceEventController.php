<?php

namespace App\Http\Controllers;

use App\ServiceEvent;
use Illuminate\Http\Request;

class ServiceEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceEvents = auth()->user()->organization->serviceEvents;
        return view('service.index', compact('serviceEvents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceEvents = auth()->user()->organization->serviceEvents;
        return view('service.create', compact('serviceEvents'));
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
     * @param  \App\ServiceEvent  $serviceEvent
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceEvent $serviceEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceEvent  $serviceEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceEvent $serviceEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceEvent  $serviceEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceEvent $serviceEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceEvent  $serviceEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceEvent $serviceEvent)
    {
        //
    }
}
