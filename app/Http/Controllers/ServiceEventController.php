<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\Exports\ServiceExports\ServiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\ServiceEvent;

class ServiceEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageService')->only('destroy');
    }

    public function index()
    {
        $serviceEvents = auth()->user()->organization->getActiveServiceEvents();
        return view('service.index', compact('serviceEvents'));
    }

    public function store(Request $request)
    {
        $activeSemester = auth()->user()->organization->getActiveSemester();
        $attributes = $this->validateServiceEvent();

        $serviceEvent = ServiceEvent::where([
            'name' => $attributes['name'],
            ['created_at', '>', $activeSemester->start_date]
        ])->first();

        $attributes['date_of_event'] = date('Y-m-d', strtotime($attributes['date_of_event']));

        if ($serviceEvent !== null) {
            if (!$serviceEvent->userAttended(auth()->user())) {
                $attributes['organization_id'] = auth()->user()->organization_id;
                $attributes['user_id'] = auth()->id();

                unset($attributes['date_of_event']);
                unset($attributes['name']);

                $serviceEvent->setLog($attributes);
            } else {
                NotificationFunctions::alert('danger', 'Already Logged for event!');
            }
        } else {
            $eventAttributes = [
                'organization_id' => auth()->user()->organization_id,
                'name' => $attributes['name'],
                'date_of_event' => $attributes['date_of_event']
            ];

            $event = ServiceEvent::Create($eventAttributes);

            $attributes['organization_id'] = auth()->user()->organization_id;
            $attributes['user_id'] = auth()->id();
            unset($attributes['date_of_event']);
            unset($attributes['name']);
            $event->setLog($attributes);
        }

        //redirect
        return redirect(route('serviceEvent.index'));
    }

    public function show(ServiceEvent $serviceEvent)
    {
        $this->authorize('update', $serviceEvent);

        return view('service.show', compact('serviceEvent'));
    }

    public function destroy(ServiceEvent $serviceEvent)
    {
        $this->authorize('update', $serviceEvent);

        if (isset($serviceEvent->serviceLogs)) {
            foreach ($serviceEvent->serviceLogs as $serviceLog) {
                $serviceLog->delete();
            }
        }

        $serviceEvent->delete();
        NotificationFunctions::alert('success', 'Successfully deleted Event and Logs!');
        return redirect(route('serviceEvent.index'));
    }

    public function export()
    {
        return Excel::download(new ServiceExport(auth()->user()->organization->serviceEvents), 'Involvement Logs.xlsx');
    }

    protected function validateServiceEvent()
    {
        return request()->validate([
            'name' => 'required',
            'money_donated' =>  ['required_without:hours_served', 'numeric', 'nullable'],
            'hours_served' =>  ['required_without:money_donated', 'numeric', 'nullable'],
            'date_of_event' => 'required'
        ]);
    }
}
