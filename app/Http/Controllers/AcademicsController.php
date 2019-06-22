<?php

namespace App\Http\Controllers;

use App\Academics;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\User;
use Illuminate\Support\Facades\Session;

class AcademicsController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
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
        return view('academics.index', compact('users'));
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
        $headings = (new HeadingRowImport)->toArray($file);

        if ($this->validateHeadingRow($headings[0][0])) {
            $this->storeFileLocally($request);
            Excel::import(new GradesImport, $file);

            $this->alert('success', 'Successfully imported new academic records!');
            return redirect('/academics');
        } else {
            $this->alert('danger', 'Failed to import new Records: Invalid format');
            return back();
        }
    }

    //Helper function for store()
    private function storeFileLocally(Request $request)
    {
        $filenameWithExt = $request->file('grades')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);                      // Get just filename
        $extension = $request->file('grades')->getClientOriginalExtension();            // Get just ext
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;                 // Filename to store TODO Figure out how to name
        $request->file('grades')->storeAs('/grades', $fileNameToStore);                 // Save Image
    }

    private function validateHeadingRow($headings): bool
    {
        $keys = [
            'student_name',
            'cumulative_gpa',
            'term_gpa'
        ];
        return count(array_intersect($keys, $headings)) === count($keys) ? true : false;
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
        $academics = auth()->user()->organization->users->firstWhere('id', $academics->user_id)->latestAcademics();
        $user = User::find($academics->user_id);
        return view('academics.override', compact('academics', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        return view('academics.manage');
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
        if ($attributes['Previous_Academic_Standing'] === $academics->Previous_Academic_Standing && $attributes['Current_Academic_Standing'] === $academics->Current_Academic_Standing) {
            $academics->update($attributes);
            $academics->updateStanding();
        } else {
            $academics = $user->latestAcademics()->update($attributes);
        }

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

    private function alert($type, $newMsg)
    {
        if (Session::has($type)) {
            $msgs = Session($type);

            array_push($msgs, $newMsg);
            Session()->forget($type);
            Session()->put($type, $msgs);
        } else {
            Session()->put($type, array($newMsg));
        }
    }
}
