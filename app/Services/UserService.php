<?php

declare(strict_types = 1);

namespace App\Services;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private array $availableUserPostedResources = [
        'threads' => 'threads',
        'comments' => 'comments'
    ];

    public function userPostedResourcesName(?string $resourcesName): string
    {
        return in_array($resourcesName, $this->availableUserPostedResources)
                    ? $resourcesName
                    : $this->availableUserPostedResources['threads'];
    }

    public function userPostedResources(string $resourcesName, int $userId)
    {
        if($resourcesName == $this->availableUserPostedResources['threads'])
        {
            return User::find($userId)->topics;
        }
        elseif($resourcesName == $this->availableUserPostedResources['comments'])
        {
            return User::find($userId)->userComments;
        }
    }
}
