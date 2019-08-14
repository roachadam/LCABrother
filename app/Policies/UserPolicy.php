<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function orgApprove(User $user, User $model)
    {
        return $user->organization_id === $model->organization_id;
    }

    public function view(User $user, User $model)
    {
        dump($user->id);
        dd($model->id);
        return $user->id === $model->id;
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function before($user, $ability)
    {
        if ($user->canManageMembers()) {
            return true;
        }
    }
}
