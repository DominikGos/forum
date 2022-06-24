<?php

namespace App\Policies;

use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicCommentPolicy
{
    use HandlesAuthorization;

    public function deleteTopicComment(User $user, TopicComment $topicComment)
    {
        return $user->id == $topicComment->user->id;
    }
}
