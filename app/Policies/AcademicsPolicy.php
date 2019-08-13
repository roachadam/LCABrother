<?php

namespace App\Policies;

use App\User;
use App\Academics;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicsPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $urlUser)
    {
        return $user->id === $urlUser->id;
    }

    public function update(User $user, Academics $academics, $urlUser)
    {
        return $user->id === $academics->user_id && $user->id === $urlUser->id;
    }

    public function before($user, $ability)
    {
        if ($user->canManageAllStudy()) {
            return true;
        }
    }
}
