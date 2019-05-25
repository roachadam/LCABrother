<?php

namespace App\Http\Controllers;

use DB;
use App\ServiceLog;
use App\ServiceEvent;
use Illuminate\Http\Request;

class ServiceEventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('ManageService', ['except' => ['index']]);
        $this->middleware('ManageService');
    }

    public function index()
    {
        $serviceEvents = auth()->user()->organization->serviceEvents;
        return view('service.index', compact('serviceEvents'));
    }

    public function create()
    {
        $serviceEvents = auth()->user()->organization->serviceEvents;
        return view('service.create', compact('serviceEvents'));
    }


    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['organization_id'] = auth()->user()->organization_id;
        $attributes['user_id'] = auth()->id();

        $logAttributes = [
            "money_donated" => $attributes['money_donated'],
            "hours_served" => $attributes['money_donated'],
            "organization_id" => auth()->user()->organization_id,
            "user_id" => auth()->id(),
        ];
        $eventAtrributes = [
            'organization_id'=> auth()->user()->organization_id,
            'name' => $attributes['name'],
            'date_of_event' => $attributes['date_of_event']
        ];

        //persist
        if(isset($attributes['service_event_id'])){
            $event = ServiceEvent::find($attributes['service_event_id']);
            $event->setLog($logAttributes);
        }
        else{
            $event = ServiceEvent::Create($eventAtrributes);
            $event->setLog($logAttributes);
        }

        //redirect
        return redirect('/dash');
    }


    public function show(ServiceEvent $serviceEvent)
    {
        //
    }


    public function edit(ServiceEvent $serviceEvent)
    {
        //
    }


    public function update(Request $request, ServiceEvent $serviceEvent)
    {
        //
    }


    public function destroy(ServiceEvent $serviceEvent)
    {
        //
    }
    protected function validateServiceEvent()
    {
        //todo: fix later, https://stackoverflow.com/questions/41805597/laravel-validation-rules-if-field-empty-another-field-required
        return request()->validate([
            'service_event_id' => 'numeric',
            'name' => ['min:3', 'max:255', 'unique:service_events,name'],
            'money_donated' => ['numeric'],
            'hours_served' => ['numeric'],
            'date_of_event',
        ]);
    }
}
