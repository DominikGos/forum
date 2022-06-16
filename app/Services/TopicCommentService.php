<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\TopicComment;
use Illuminate\Support\Facades\Storage;

class TopicCommentService
{
    public function destroyFiles(TopicComment $comment)
    {
        $topicCommentFilesPaths = array_column($comment->topicCommentFiles->toArray(), 'path');

        Storage::delete($topicCommentFilesPaths);

        $comment->delete();
    }
}
