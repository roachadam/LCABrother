<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarItem;
use App\Event;
use App\AttendanceEvent;
use App\CalendarCatagory;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageCalendar')->except('index', 'show');
    }

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
            "start_datetime" => ['required'],
            "end_datetime" => ['nullable'],
            "guestList" => ['nullable'],
            "attendance" => ['nullable'],
            "involvement" => ['numeric'],
            "calendar_catagories_id" => ['required']
        ]);


        $makeGuest = isset($attributes['guestList']);
        $allowAttendance = isset($attributes['attendance']);
        $involvementId = $attributes['involvement'];
        $calendarCatagory = $attributes['calendar_catagories_id'];

        unset($attributes['calendar_catagories_id']);
        unset($attributes['guestList']);
        unset($attributes['attendance']);
        unset($attributes['involvement']);

        if (!isset($attributes['end_datetime'])) {
            $attributes['end_datetime'] = $attributes['start_datetime'];
        }
        $category = CalendarCatagory::find($calendarCatagory);

        // remove am/pm and reformat dates
        $attributes['start_datetime'] = new \DateTime($attributes['start_datetime']);
        $attributes['end_datetime'] = new \DateTime($attributes['end_datetime']);


        $org = auth()->user()->organization;
        $calendarItem = $org->addCalendarItem($attributes);
        $calendarItem->setCatagory($category);

        if ($allowAttendance) {
            if ($involvementId != 0) {
                $attendanceEvent = auth()->user()->organization->addAttendanceEvent([
                    'calendar_item_id' => $calendarItem->id,
                    'involvement_id' => $involvementId,
                ]);
            } else {
                $attendanceEvent = auth()->user()->organization->addAttendanceEvent([
                    'calendar_item_id' => $calendarItem->id,
                ]);
            }
        }
        if ($makeGuest) {
            return view('calendar.guestList', compact('calendarItem'));
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
        $this->authorize('update', $calendarItem);

        if ($calendarItem->hasEvent()) {
            $event = $calendarItem->event;
            $invites = $event->invites;
        } else {
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
        $this->authorize('update', $calendarItem);

        return view('calendar.edit', compact('calendarItem'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarItem $calendarItem)
    {
        $this->authorize('update', $calendarItem);

        if ($calendarItem->hasEvent()) {
            $event = $calendarItem->event;
            $event->delete();
        }
        $calendarItem->delete();
        return redirect('/calendarItem');
    }

    public function addEvent(Request $request, CalendarItem $calendarItem)
    {
        $this->authorize('update', $calendarItem);

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
    public function addCategory(Request $request)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $org = auth()->user()->organization;
        $org->addCalendarCategory($attributes['name'], $attributes['color']);

        return redirect('/calendarItem');
    }

    public function categoryDelete(Request $request, CalendarCatagory $CalendarCatagory){
        $calendarItems = auth()->user()->organization->calendarItem;

        $match = [
            'organization_id' => auth()->user()->organization->id,
            'name' => 'General'
        ];
        $general = CalendarCatagory::find($match)->first();

        foreach($calendarItems as $item){
            if($item->calendarCatagory == $CalendarCatagory){
                $item->setCatagory($general);
            }
        }

        $CalendarCatagory->delete();
        return redirect('/calendarItem');
    }
}
