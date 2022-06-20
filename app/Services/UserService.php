<?php

declare(strict_types = 1);

namespace App\Services;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private static array $availableUserPostedResources = [
        'threads' => 'threads',
        'comments' => 'comments'
    ];

    public function userPostedResourcesName(?string $resourcesName): string
    {
        return in_array($resourcesName, self::$availableUserPostedResources)
                    ? $resourcesName
                    : self::$availableUserPostedResources['threads'];
    }

    public function userPostedResources(string $resourcesName, int $userId)
    {
        switch ($resourcesName) {
            case self::$availableUserPostedResources['threads']:
                return User::find($userId)->topics;
                break;

            case self::$availableUserPostedResources['comments']:
                return TopicComment::where('user_id', $userId)->get();
                break;
        }

    }
}
