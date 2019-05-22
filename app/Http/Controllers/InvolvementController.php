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
    }

    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
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
        //
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
