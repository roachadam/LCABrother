<?php

namespace App\Http\Controllers;

use App\ServiceEvent;
use Illuminate\Http\Request;

class ServiceEventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
        //validate
        dd($request);
        $attributes = $this->validateServiceEvent();
        $attributes['organization_id'] = auth()->user()->organization_id;
        $attributes['user_id'] = auth()->id();

        if($attributes['service_event_id'] != null){
            $log = ServiceLog::create($attributes);
        }
        else{
            $eventAtrributes = [
                'organization_id'=> auth()->user()->organization_id,
                'name' => $attributes['name'],
                'date_of_event' => $attributes['date_of_event']
            ];
            $event = ServiceEvent::Create($eventAtrributes);
            unset($attributes['name']);
            unset($attributes['date_of_event']);
            $event->ServiceLogs()->create($attributes);
        }
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
        return request()->validate([
            'service_event_id' => 'required_if:name,null',
            'name' => ['required_if:service_event_id,null','min:3', 'max:255', 'unique:service_events,name'],
            'money_donated' => ['required_if:hours_served, null', 'numeric'],
            'hours_served' => ['required_if:money_donated, null', 'numeric'],
            'date_of_event' => 'required'
        ]);
    }
}
