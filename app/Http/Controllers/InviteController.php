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
        $this->authorize('view', $event);
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
        $this->authorize('view', $event);
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

        foreach ($event->invites as $invite) {
            if (strtolower($attributes['guest_name']) === strtolower($invite->guest_name)) {
                event(new DuplicateGuestInvited($invite));
                return redirect(route('invite.create', $event));
            }
        }

        if (auth()->user()->hasInvitesRemaining($event)) //If you have invites remaining, store it
        {
            $attributes['user_id'] = auth()->id();
            $event->addInvite($attributes);
            NotificationFunctions::alert('success', $attributes['guest_name'] . ' has been invited!');
        }

        if(auth()->user()->hasInvitesRemaining($event))
        {
            return back();
        }
        else
        {
            return redirect('/dash');
        }
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
