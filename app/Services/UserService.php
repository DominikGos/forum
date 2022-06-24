<?php

declare(strict_types = 1);

namespace App\Services;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private static array $availableUserPostedResources = [
        'threads' => 'threads',
        'comments' => 'comments'
    ];
    
    private const AVATAR_PATH = 'avatar';

    public function userPostedResourcesName(?string $resourcesName): string
    {
        return in_array($resourcesName, self::$availableUserPostedResources)
                    ? $resourcesName
                    : self::$availableUserPostedResources['threads'];
    }

    public function userPostedResources(string $resourcesName, User $user): Collection
    {
        switch ($resourcesName) {
            case self::$availableUserPostedResources['threads']:
                return $user->topics;
                break;

            case self::$availableUserPostedResources['comments']:
                return TopicComment::where('user_id', $user->id)->get();
                break;
        }
    }

    public function update(array $data, User $user)
    {
        if( ! empty($data['avatar'])) {
            $avatarPath = $data['avatar']->store(self::AVATAR_PATH);
        }

        if( ! empty($data['deleteAvatar']) && $user->avatar) {
            $user->avatar = null;
        }

        $user->name = $data['name'] ?? $user->name;
        $user->avatar = $avatarPath ?? $user->avatar;

        $user->save();
    }
}
