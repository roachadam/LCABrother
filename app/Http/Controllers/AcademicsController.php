<?php

namespace App\Http\Controllers;

use App\Academics;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;

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
        $users = auth()->user()->organization->users;

        foreach ($users as $user) {
            $data = $user->latestAcademics();
        }
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
        $request->validate([
            'grades' => 'required|file|max:2048',
        ]);

        $file = request()->file('grades');
        self::storeFileLocally($request);
        Excel::import(new GradesImport, $file);

        return redirect('/academics');
    }

    private function storeFileLocally(Request $request)
    {

        $filenameWithExt = $request->file('grades')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);                      // Get just filename
        $extension = $request->file('grades')->getClientOriginalExtension();            // Get just ext
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;                                // Filename to store TODO Figure out how to name
        $request->file('grades')->storeAs('/grades', $fileNameToStore);                 // Save Image
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academics  $academics
     * @return \Illuminate\Http\Response
     */
    //public function edit(Academics $academics)
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
    public function update(Request $request, Academics $academics)
    { }

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
}
