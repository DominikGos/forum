<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicComment;
use App\Models\TopicComment as ModelTopicComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicCommentController extends Controller
{
    public function store(StoreTopicComment $request)
    {
        ModelTopicComment::create([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'text' => $request->text
        ]);

        return redirect()->route('topic.get', ['id' => $request->topic_id])
            ->with('comment-create-success', 'Comment has been created successful');
    }
}
