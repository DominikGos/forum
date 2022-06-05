<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicComment;
use App\Models\TopicComment as ModelTopicComment;
use Illuminate\Http\Request;

class TopicComment extends Controller
{
    public function store(StoreTopicComment $request)
    {
        $temporaryUserId = 1;

        ModelTopicComment::create([
            'user_id' => $temporaryUserId,
            'topic_id' => $request->topic_id,
            'text' => $request->text
        ]);

        return redirect()->route('topic.get', ['id' => $request->topic_id]);
    }
}
