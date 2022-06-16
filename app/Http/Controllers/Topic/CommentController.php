<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTopicComment;
use App\Http\Requests\StoreTopicComment;
use App\Models\TopicComment;
use App\Models\TopicCommentFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreTopicComment $request)
    {
        $topicCommentId = TopicComment::insertGetId([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'text' => $request->text,
            'created_at' => Carbon::now(),
        ]);

        foreach($request->file('files') ?? [] as $file) {
            $path = $file->store('topic-comment');

            TopicCommentFile::create([
                'topic_comment_id' => $topicCommentId,
                'user_id' => Auth::id(),
                'path' => $path
            ]);
        }

        return redirect()->route('topic.get', ['id' => $request->topic_id])
            ->with('comment-create-success', 'Comment has been created successful');
    }

    public function destroy(DestroyTopicComment $request, int $id)
    {
        $topicComment = TopicComment::find($id);

        $topicComment->delete();

        return redirect()
            ->route('topic.get', ['id' => $topicComment->topic->id])
            ->with('topic-comment-delete-success', 'Topic comment has been removed successful');
    }
}
