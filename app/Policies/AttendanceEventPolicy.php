<?php

namespace App\Policies;

use App\User;
use App\AttendanceEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the attendance event.
     *
     * @param  \App\User  $user
     * @param  \App\AttendanceEvent  $attendanceEvent
     * @return mixed
     */
    public function update(User $user, AttendanceEvent $attendanceEvent)
    {
        return $user->organization_id === $attendanceEvent->organization_id;
    }
}
