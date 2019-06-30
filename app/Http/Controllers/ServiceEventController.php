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
        $this->middleware('orgverified');
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
        $attributes = $this->validateServiceEvent();
        $serviceEvent = ServiceEvent::where('name', $attributes['name'])->first();
        $attributes['date_of_event'] = date('Y-m-d', strtotime($attributes['date_of_event']));
        if ($serviceEvent!==null) {
            $attributes['organization_id'] = auth()->user()->organization_id;
            $attributes['user_id'] = auth()->id();
            unset($attributes['date_of_event']);

            unset($attributes['name']);

            $serviceEvent->setLog($attributes);
        } else {
            $eventAtrributes = [
                'organization_id' => auth()->user()->organization_id,
                'name' => $attributes['name'],
                'date_of_event' => $attributes['date_of_event']
            ];

            $event = ServiceEvent::Create($eventAtrributes);

            $attributes['organization_id'] = auth()->user()->organization_id;
            $attributes['user_id'] = auth()->id();
            unset($attributes['date_of_event']);
            unset($attributes['name']);
            $event->setLog($attributes);
        }

        //redirect
        return back();
    }


    public function show(ServiceEvent $serviceEvent)
    {
        return view('service.show', compact('serviceEvent'));
    }


    public function edit(ServiceEvent $serviceEvent)
    {
        //
    }


    public function update(Request $request, ServiceEvent $serviceEvent)
    { }


    public function destroy(ServiceEvent $serviceEvent)
    {
        $serviceEvent->delete();
        return redirect('/serviceEvent');
    }
    protected function validateServiceEvent()
    {
        //todo: fix later, https://stackoverflow.com/questions/41805597/laravel-validation-rules-if-field-empty-another-field-required
        return request()->validate([
            'name' => 'required',
            'money_donated' =>  'required_without:hours_served',
            'hours_served' =>  'required_without:money_donated',
            'date_of_event' => 'required'
        ]);
    }

    public function indexByUser(Request $request){
        $users = auth()->user()->organization->getVerifiedMembers();
        return view('service.indexByUser', compact('users'));
    }
}
