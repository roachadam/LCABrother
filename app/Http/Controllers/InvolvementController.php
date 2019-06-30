<?php

namespace App\Http\Controllers;

use App\Involvement;
use Illuminate\Http\Request;
use App\Imports\InvolvementsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Commons\NotificationFunctions;
use App\Commons\HelperFunctions;
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
        if ($this->checkIfInvolvementEventExists($attributes)) {
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
        $headings = (new HeadingRowImport)->toArray($file);
        $requiredHeadings = [
            'event_type',
            'brothers_involved',
            'date'
        ];

        if (HelperFunctions::validateHeadingRow($requiredHeadings, $headings[0][0])) {
            HelperFunctions::storeFileLocally($file, '/involvement');
            Excel::import(new InvolvementsImport, $file);

            NotificationFunctions::alert('success', 'Successfully imported new Involvement records!');
            return redirect('/involvementLog');
        } else {
            NotificationFunctions::alert('danger', 'Failed to import new Records: Invalid format');
            return back();
        }
    }


    private function checkIfInvolvementEventExists($attributes)
    {
        $involvements = auth()->user()->organization->involvement;

        return $involvements->filter(function ($involvement) use ($attributes) {
            return $involvement['name'] === $attributes['name'] && $involvement['organization_id'] === auth()->user()->organization->id;
        })->isNotEmpty();
    }
}
