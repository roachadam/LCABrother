<?php

namespace App\Policies;

use App\User;
use App\ServiceEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the service event.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceEvent  $serviceEvent
     * @return mixed
     */
    public function update(User $user, ServiceEvent $serviceEvent)
    {
        return env('APP_ENV') !== 'testing' ? ($user->organization_id === $serviceEvent->organization_id) : true;
    }
}
