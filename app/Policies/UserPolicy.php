<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function userList(User $user) {
        $userRoles = array_column(Auth::user()->userRoles->toArray(), 'role');

        return in_array('admin', $userRoles)
                    ? Response::allow()
                    : Response::deny('You must be an administrator.');
    }

    public function userUpdate(User $authenticated, User $user)
    {
        return $authenticated->id === $user->id;
    }
}
