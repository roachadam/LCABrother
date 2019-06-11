<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarItem;
use App\Event;
use App\AttendanceEvent;

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
        $attributes = $request->validate([
            "name" => ['required'],
            "description" => ['required'],
            "start_date" => ['required'],
            "end_date" => ['nullable'],
            "guestList" => ['nullable'],
            "attendance" => ['nullable'],
            "involvement" => ['numeric']
        ]);

        $makeGuest = isset($attributes['guestList']);
        $allowAttendance = isset($attributes['attendance']);
        $involvementId = $attributes['involvement'];

        unset($attributes['guestList']);
        unset($attributes['attendance']);
        unset($attributes['involvement']);

        if(!isset($attributes['end_date'])){
            $attributes['end_date'] = $attributes['start_date'];
        }

        $org = auth()->user()->organization;
        $calendarItem = $org->addCalendarItem($attributes);


        if($allowAttendance){
            if($involvementId != 0){
                $attendanceEvent = auth()->user()->organization->addAttendanceEvent([
                    'calendar_item_id' => $calendarItem->id,
                    'involvement_id' => $involvementId,
                ]);
            }
            else{
                $attendanceEvent = auth()->user()->organization->addAttendanceEvent([
                    'calendar_item_id' => $calendarItem->id,
                ]);
            }

        }
        if($makeGuest)
        {
            return view('calendar.guestList',compact('calendarItem'));
        }
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarItem $calendarItem)
    {
        if($calendarItem->hasEvent()){
            $event = $calendarItem->event;
            $invites = $event->invites;
        }else{
            $event = null;
            $invites = null;
        }
        $attendanceEvent = $calendarItem->attendanceEvent;
        return view('calendar.show', compact('calendarItem', 'event', 'invites', 'attendanceEvent'));
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
        if($calendarItem->hasEvent()){
            $event = $calendarItem->event;
            $event->delete();
        }
        $calendarItem->delete();
        return redirect('/calendarItem');
    }
    public function addEvent(Request $request, CalendarItem $calendarItem){
        $attributes = request()->validate([
            'name' => 'required',
            'date_of_event' => 'required',
            'num_invites' => 'required',
        ]);

        $org = auth()->user()->organization;
        $event = $org->addEvent($attributes);

        $calendarItem->event()->associate($event)->save();
        return redirect('/event');
    }
}
