<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\File;

class TopicService extends ForumService
{
    private const TOPIC_FILES_PATH = 'topic';

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

    public function store(array $data)
    {
        $topicId = Topic::insertGetId([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'text' => $data['text'],
            'created_at' => Carbon::now()
        ]);

        foreach($data['files'] ?? [] as $file)
        {
            $path = $file->store(self::TOPIC_FILES_PATH);

            File::create([
                'fileable_id' => $topicId,
                'fileable_type' => Topic::class,
                'path' => $path
            ]);
        }
    }
}
