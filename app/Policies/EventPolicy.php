<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Event $event)
    {
        return $user->organization_id === $event->organization_id;
    }
}
