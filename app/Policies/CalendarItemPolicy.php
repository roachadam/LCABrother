<?php

namespace App\Policies;

use App\User;
use App\CalendarItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the calendar item.
     *
     * @param  \App\User  $user
     * @param  \App\CalendarItem  $calendarItem
     * @return mixed
     */
    public function update(User $user, CalendarItem $calendarItem)
    {
        return $user->organization_id === $calendarItem->organization_id;
    }
}
