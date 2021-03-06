<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InvolvementsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Commons\NotificationFunctions;
use App\Commons\ImportHelperFunctions;
use App\Commons\InvolvementHelperFunctions;
use App\Involvement;

class InvolvementController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageInvolvement')->except('index');
        $this->middleware('RestrictAssociates')->only('index');
    }

    public function index()
    {
        $user = auth()->user();
        $organization = $user->organization;

        $canManageInvolvement = $user->canManageInvolvement();
        $involvements = $organization->involvement;
        $users = $organization->getActiveMembers();
        $events = auth()->user()->organization->involvement;

        return view('involvement.index', compact('users', 'canManageInvolvement', 'involvements', 'events'));
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
            'name' => 'required',
            'points' => ['required', 'numeric', 'min:0', 'max:999'],
        ]);

        if (InvolvementHelperFunctions::checkIfInvolvementEventExists($attributes)->isNotEmpty()) {
            NotificationFunctions::alert('danger', 'An Involvement event for ' . $attributes['name'] . 's already exits');
            return redirect(route('involvement.adminView'));
        } else {
            $org = auth()->user()->organization;
            $org->addInvolvementEvent($attributes);

            NotificationFunctions::alert('success', 'Successfully created involvement event for ' . $attributes['name'] . 's');

            return back();
        }
    }

    public function update(Request $request, Involvement $involvement)
    {
        $attributes = request()->validate([
            'name' => ['required'],
            'points' => ['required', 'numeric', 'min:0', 'max:999']
        ]);

        $involvement->update($attributes);

        NotificationFunctions::alert('success', 'Successfully updated event!');
        return back();
    }

    public function import(Request $request)
    {
        $request->validate(
            [
                'InvolvementData' => 'required|file|max:2048|mimes:xlsx',
                'test' => 'boolean'
            ],
            //Error messages
            ['InvolvementData.mimes' => 'You must upload a spread sheet']
        );

        $file = request()->file('InvolvementData');

        $requiredHeadings = [
            'name',
            'members_involved',
            'date'
        ];

        if (ImportHelperFunctions::validateHeadingRow($file, $requiredHeadings)) {
            if (!$request['test']) {
                ImportHelperFunctions::storeFileLocally($file, '/involvement');
            }

            $organization = auth()->user()->organization;
            $import = new InvolvementsImport(InvolvementHelperFunctions::getExistingLogs($request['test']), $organization, $organization->users);
            Excel::import($import, $file);

            return $this->checkNullEvents($import->getNewServiceEvents(), $organization, $request['test']);
        } else {
            NotificationFunctions::alert('danger', 'Failed to import new Records: Invalid format');
            return back();
        }
    }

    private function checkNullEvents($events, $organization, $test)
    {
        if ($events->where('points', null)->isNotEmpty() && $organization->involvement->where('name', $test)) {
            return view('/involvement/edit', compact('events'));
        } else {
            NotificationFunctions::alert('success', 'Successfully imported new Involvement records!');
            return redirect('/involvement');
        }
    }

    public function setPoints(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'point_value' => ['required'],
        ]);

        $pointData = array_combine($attributes['name'], $attributes['point_value']);

        $organization = auth()->user()->organization;
        $involvements = (env('APP_ENV') === 'testing') ? (Involvement::where('organization_id', $organization->id)->get()) : $organization->involvement;

        foreach ($pointData as $eventName => $points) {
            $involvements->where('name', $eventName)->first()->update(['points' => $points]);
        }

        NotificationFunctions::alert('success', 'Successfully imported new Involvement records!');
        return redirect('/involvement');
    }

    public function events()
    {
        $events = auth()->user()->organization->involvement;
        return view('/involvement/events', compact('events'));
    }

    public function destroy(Involvement $involvement)
    {
        $involvement->delete();
        NotificationFunctions::alert('success', 'Event has been deleted!');

        return redirect(route('involvement.adminView'));
    }
}
