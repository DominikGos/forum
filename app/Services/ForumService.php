<?php

declare(strict_types = 1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;

abstract class ForumService
{
    abstract public function store(array $data);

    public function destroyFiles(object $forumResource)
    {
        $files = $forumResource->files;

        $forumResourceFilesPaths = array_column($files->toArray(), 'path');

        Storage::delete($forumResourceFilesPaths);

        foreach($files as $file) {
            $file->delete();
        }

        $forumResource->delete();
    }
}
