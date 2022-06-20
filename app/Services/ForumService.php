<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

abstract class ForumService
{
    abstract public function store(array $data);

    public function destroyForumResource(object $forumResource)
    {
        $this->destroyFiles($forumResource->files);

        $forumResource->delete();
    }

    public function destroyFiles(Collection $files)
    {
        $filesPaths = array_column($files->toArray(), 'path');

        Storage::delete($filesPaths);

        foreach($files as $file) {
            $file->delete();
        }
    }
}
