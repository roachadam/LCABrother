<?php

namespace App\Http\Controllers;

use App\Commons\NotificationFunctions;
use App\Events\DuplicateGuestInvited;
use Illuminate\Http\Request;
use App\Invite;
use App\Event;

class InviteController extends Controller
{
    public function index(Event $event)
    {
        $invites = auth()->user()->getInvites($event);
        return view('invites.index', compact('event', 'invites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('invites.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $attributes = request()->validate([
            'guest_name' => 'required',
        ]);
        $invites = $event->invites;
        foreach ($invites as $invite) {
            if (strtolower($attributes['guest_name']) === strtolower($invite->guest_name)) {
                event(new DuplicateGuestInvited($invite));
                return redirect('/event/' . $event->id . '/invite');
            }
        }

        if (auth()->user()->hasInvitesRemaining($event)) //If you have invites remaining, store it
        {
            $attributes['user_id'] = auth()->id();
            $event->addInvite($attributes);
            auth()->user()->getInvitesRemaining($event);
        }

        return redirect(route('event.index'));
    }

    public function all(Event $event)
    {
        $invites = $event->invites;
        return view(' invites . all ', compact(' event ', ' invites'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invite $invite)
    {
        $invite->delete();
        NotificationFunctions::alert('success', 'Successfully deleted guest!');
        return back();
    }
}
