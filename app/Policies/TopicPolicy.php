<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    use HandlesAuthorization;

    public function deleteTopic(User $user, Topic $topic) {
        return $user->id == $topic->user_id
                        ? Response::allow()
                        : Response::deny('You must be an administrator.');
    }

    public function updateTopic(User $user, Topic $topic) {
        return $user->id == $topic->user_id;
    }
}
