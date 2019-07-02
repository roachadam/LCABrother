<?php

namespace App\Http\Controllers;

use App\Involvement;
use Illuminate\Http\Request;
use App\Imports\InvolvementsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Commons\NotificationFunctions;
use App\Commons\ImportHelperFunctions;
use App\Commons\InvolvementHelperFunctions;
use DB;

class InvolvementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ManageInvolvement');
        $this->middleware('orgverified');
    }

    public function index()
    {
        $involvements = auth()->user()->organization->involvement;
        return view('involvement.index', compact('involvements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('involvement.create');
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
            return back();
        } else {
            //persist
            $org = auth()->user()->organization;
            $org->addInvolvementEvent($attributes);

            NotificationFunctions::alert('success', 'Successfully created and involvement event for ' . $attributes['name'] . 's');
            //redirect
            return redirect('/involvement');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function edit(Involvement $involvement)
    {
        return view('involvement.edit', compact('involvement'));
    }

    public function update(Request $request)
    {
        dd($request->all());
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
            Excel::import(new InvolvementsImport, $file);

            $nullEvents = auth()->user()->organization->involvement->filter(function ($event) {
                return $event['points'] === null && $event['organization_id'] === auth()->user()->organization->id;
            });

            if ($nullEvents->isNotEmpty()) {
                return view('/involvement/edit', compact('nullEvents'));
            } else {
                NotificationFunctions::alert('success', 'Successfully imported new Involvement records!');
                return redirect('/involvementLogs');
            }
        } else {
            NotificationFunctions::alert('danger', 'Failed to import new Records: Invalid format');
            return back();
        }
    }
}
