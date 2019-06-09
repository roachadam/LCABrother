<?php

namespace App\Http\Controllers;

use App\Involvement;
use Illuminate\Http\Request;
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

       //persist
       $org = auth()->user()->organization;
       $org->addInvolvementEvent($attributes);

       //redirect
       return redirect('/involvement');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function show(Involvement $involvement)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Involvement $involvement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Involvement $involvement)
    {
        //
    }
}
