<?php

namespace App\Http\Controllers;

use App\Academics;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Commons\NotificationFunctions;
use App\Commons\ImportHelperFunctions;
use App\Events\OverrideAcademics;
use App\AcademicStandings;

class AcademicsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('orgverified');
        $this->middleware('ManageAcademics');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('organization_id', auth()->user()->organization->id)->get();
        $users->load(['Academics' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('academics.index', compact('users', 'academicStandings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'grades' => 'required|file|max:2048|mimes:xlsx',
            ],
            //Error messages
            ['grades.mimes' => 'You must upload a spread sheet']
        );

        $file = request()->file('grades');
        $requiredHeadings = [
            'student_name',
            'cumulative_gpa',
            'term_gpa'
        ];

        if (ImportHelperFunctions::validateHeadingRow($file, $requiredHeadings)) {
            ImportHelperFunctions::storeFileLocally($file, '/grades');
            Excel::import(new GradesImport, $file);

            NotificationFunctions::alert('success', 'Successfully imported new academic records!');
            return redirect('/academics');
        } else {
            NotificationFunctions::alert('danger', 'Failed to import new Records: Invalid format');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    public function show(Academics $academics)
    {
        //
    }

    public function edit(Academics $academics)
    {
        $organization = auth()->user()->organization;

        $academics = $organization->users->firstWhere('id', $academics->user_id)->latestAcademics();
        $user = User::find($academics->user_id);
        $academicStandings = AcademicStandings::where('organization_id', $organization->id)->get()->sortByDesc('Term_GPA_Min');
        return view('academics.override', compact('academics', 'user', 'academicStandings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $usedStandings = array();
        $newAcademicStandings = array();

        $academicStandings = auth()->user()->organization->academicStandings;
        foreach (auth()->user()->organization->users as $user) {
            if (isset($user->latestAcademics()->Current_Academic_Standing)) {
                array_push($usedStandings, $user->latestAcademics()->Current_Academic_Standing);
            }
        }

        foreach ($academicStandings->all() as $academicStanding) {
            if (in_array($academicStanding->name, $usedStandings)) {
                array_push($newAcademicStandings, $academicStanding->name);
            }
        }

        return view('academics.manage', compact('academicStandings', 'newAcademicStandings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Academics $academics)
    {
        $attributes = request()->all();
        //dd($attributes);
        if ($attributes['Previous_Academic_Standing'] === $academics->Previous_Academic_Standing && $attributes['Current_Academic_Standing'] === $academics->Current_Academic_Standing) {
            $academics->update($attributes);
            $academics->updateStanding();
        } else {
            $academics->update($attributes);
        }

        Event(new OverrideAcademics($user, $academics));
        return redirect('/academics');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academics $academics)
    {
        //
    }

    public function getExampleFile()
    {
        return response()->download(public_path('/storage/grades/exampleFiles/ExampleGradeUploadFile.xlsx'));
    }
}
