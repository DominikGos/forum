<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function userList(User $user) {
        return $user->admin
                    ? Response::allow()
                    : Response::deny('You must be an administrator.');
    }

    public function userUpdate(User $authenticated, User $user)
    {
        return $authenticated->id === $user->id;
    }
}
