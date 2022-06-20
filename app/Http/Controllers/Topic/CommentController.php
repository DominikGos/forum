<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTopicComment;
use App\Http\Requests\StoreTopicComment;
use App\Models\TopicComment;
use App\Services\TopicCommentService;

class CommentController extends Controller
{
    private TopicCommentService $topicCommentService;

    public function __construct(TopicCommentService $topicCommentService)
    {
        $this->topicCommentService = $topicCommentService;
    }

    public function store(StoreTopicComment $request)
    {
        $this->topicCommentService->store($request->all());

        return redirect()->route('topic.get', ['id' => $request->topic_id])
            ->with('comment-create-success', 'Comment has been created successful');
    }

    public function destroy(DestroyTopicComment $request, int $id)
    {
        $topicComment = TopicComment::find($id);

        if($topicComment)
        {
            $this->topicCommentService->destroyForumResource($topicComment);
            $topicComment->delete();
        }

        return redirect()
            ->route('topic.get', ['id' => $topicComment->topic->id])
            ->with('topic-comment-delete-success', 'Topic comment has been removed successful');
    }
}
