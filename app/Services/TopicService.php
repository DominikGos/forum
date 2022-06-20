<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Facades\Storage;

class TopicService
{
    public function listSequence(?string $sequence): ?string
    {
        $accessibleSequences = [
            'desc',
            'asc',
        ];

        return in_array($sequence, $accessibleSequences)
            ? $sequence
            : $accessibleSequences[0];
    }

    public function destroyFiles(Topic $topic)
    {
        $topicFilesPaths = array_column($topic->files->toArray(), 'path');

        Storage::delete($topicFilesPaths);

        $topic->delete();
    }
}
