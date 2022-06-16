<?php

declare(strict_types = 1);

namespace App\Services;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private array $availableResources = [
        'threads',
        'comments'
    ];

    public function userPostedResourcesName(?string $resourcesName): string
    {
        return in_array($resourcesName, $this->availableResources)
                    ? $resourcesName
                    : $this->availableResources[0];
    }

    public function userPostedResources(string $resourcesName, int $userId)
    {
        if($resourcesName == $this->availableResources[0])
        {
            return User::find($userId)->topics;
        }
        elseif($resourcesName == $this->availableResources[1])
        {
            return TopicComment::where('user_id', $userId)->get();
        }
    }
}
