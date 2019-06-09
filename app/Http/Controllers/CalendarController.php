<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarItem;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendarItems = auth()->user()->organization->calendarItem;

        return view('calendar.index', compact('calendarItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        $makeGuest = isset($attributes['guestList']);
        unset($attributes['guestList']);

        if(!isset($attributes['end_date'])){
            $attributes['end_date'] = $attributes['start_date'];
        }
        
        $org = auth()->user()->organization;
        $calendarItem = $org->addCalendarItem($attributes);

        if($makeGuest)
        {
            return view('calendar.guestList',compact('calendarItem'));
        }
        else
        {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarItem $calendarItem)
    {
        return view('calendar.show', compact('calendarItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarItem $calendarItem)
    {
        return view('calendar.edit', compact('calendarItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarItem $calendarItem)
    {
        $calendarItem->delete();
        return redirect('/calendar');
    }
}
