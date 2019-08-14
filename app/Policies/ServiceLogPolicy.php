<?php

namespace App\Policies;

use App\User;
use App\ServiceLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceLogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, ServiceLog $serviceLog)
    {
        return $user->id === $serviceLog->user_id;
    }

    public function breakdown(User $user, User $urlUser)
    {
        return $user->id === $urlUser->id;
    }

    public function before($user, $ability)
    {
        if ($user->canManageService()) {
            return true;
        }
    }
}
