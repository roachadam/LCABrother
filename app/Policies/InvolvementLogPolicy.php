<?php

namespace App\Policies;

use App\User;
use App\InvolvementLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvolvementLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $urlUser)
    {
        return $user->id === $urlUser->id;
    }

    public function before($user, $ability)
    {
        if ($user->canManageInvolvement()) {
            return true;
        }
    }
}
