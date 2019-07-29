<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('ManageEvents')->except('index');
    }

    public function index()
    {
        $events = auth()->user()->organization->event;
        return view('events.index', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'date_of_event' => 'required',
            'num_invites' => ['required', 'numeric'],
        ]);

        $org = auth()->user()->organization;
        $org->addEvent($attributes);

        NotificationFunctions::alert('success', 'Successfully created new Event!');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $invites = $event->invites;
        return view('events.show', compact('event', 'invites'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $attributes = request()->all();

        $event->update($attributes);

        NotificationFunctions::alert('success', 'Successfully updated Event!');
        return redirect(route('event.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        NotificationFunctions::alert('primary', 'Successfully deleted Event!');
        return redirect(route('event.index'));
    }
}
