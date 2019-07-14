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
    }

    public function index()
    {
        $user = auth()->user();
        $organization = $user->organization;

        $canManageInvolvement = $user->canManageInvolvement();
        $involvements = $organization->involvement;
        $verifiedMembers = $organization->getVerifiedMembers();
        $users = $organization->getVerifiedMembers();

        return view('involvement.index', compact('users', 'canManageInvolvement', 'involvements', 'verifiedMembers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $attributes = request()->validate([
            'name' => 'required',
            'points' => ['required', 'numeric', 'min:0', 'max:999'],
        ]);

        //Check if that event already exists
        if (InvolvementHelperFunctions::checkIfInvolvementEventExists($attributes)->isNotEmpty()) {
            NotificationFunctions::alert('danger', 'An Involvement event for ' . $attributes['name'] . 's already exits');
            return redirect(route('involvement.adminView'));
        } else {
            //persist
            $org = auth()->user()->organization;
            $org->addInvolvementEvent($attributes);

            NotificationFunctions::alert('success', 'Successfully created and involvement event for ' . $attributes['name'] . 's');
            //redirect
            return redirect(route('involvement.adminView'));
        }
    }

    public function update(Request $request, Involvement $involvement)
    {
        $attributes = request()->validate([
            'name' => ['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'points' => ['required', 'numeric', 'min:0', 'max:999']
        ]);

        $involvement->update($attributes);

        NotificationFunctions::alert('success', 'Successfully updated event!');
        return redirect(route('involvement.adminView'));
    }

    public function import(Request $request)
    {
        $request->validate(
            [
                'InvolvementData' => 'required|file|max:2048|mimes:xlsx',
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
            ImportHelperFunctions::storeFileLocally($file, '/involvement');

            $organization = auth()->user()->organization;
            $import = new InvolvementsImport(InvolvementHelperFunctions::getExistingLogs(), $organization, $organization->users);
            Excel::import($import, $file);

            return $this->checkNullEvents($import->getNewServiceEvents());
        } else {
            NotificationFunctions::alert('danger', 'Failed to import new Records: Invalid format');
            return redirect(route('involvement.index'));
        }
    }

    private function checkNullEvents($events)
    {
        if ($events->isNotEmpty()) {
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
        $involvements = auth()->user()->organization->involvement;

        foreach ($pointData as $eventName => $points) {
            $event = $involvements->filter(function ($event) use ($eventName, $points) {
                return $event['name'] === $eventName && $event['organization_id'] === auth()->user()->organization->id;
            })->first();
            $event->update(['points' => $points]);
        }
        return redirect('/involvement');
    }

    public function adminView()
    {
        $events = auth()->user()->organization->involvement;
        return view('/involvement/adminView', compact('events'));
    }
}
