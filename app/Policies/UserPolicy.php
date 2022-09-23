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

        return true;
    }

    public function userUpdate(User $authenticated, User $user)
    {
        return $authenticated->id === $user->id;
    }
}
