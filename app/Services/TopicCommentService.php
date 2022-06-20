<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\File;
use App\Models\TopicComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TopicCommentService extends ForumService
{
    private const TOPIC_COMMENT_FILES_PATH = 'topic-comment';

    public function store(array $data)
    {
        $topicCommentId = TopicComment::insertGetId([
            'user_id' => Auth::id(),
            'topic_id' => $data['topic_id'],
            'text' => $data['text'],
            'created_at' => Carbon::now(),
        ]);

        foreach($data['files'] ?? [] as $file)
        {
            $path = $file->store(self::TOPIC_COMMENT_FILES_PATH);

            File::create([
                'fileable_id' => $topicCommentId,
                'fileable_type' => TopicComment::class,
                'path' => $path
            ]);
        }
    }

}
