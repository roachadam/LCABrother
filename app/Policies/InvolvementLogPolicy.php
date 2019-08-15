<?php

namespace App\Policies;

use App\User;
use App\InvolvementLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvolvementLogPolicy
{
    use HandlesAuthorization;

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
