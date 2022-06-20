<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTopicComment;
use App\Http\Requests\StoreTopicComment;
use App\Models\File;
use App\Models\TopicComment;
use App\Models\TopicCommentFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TopicCommentService;

class CommentController extends Controller
{
    private TopicCommentService $topicCommentService;
    private const TOPIC_COMMENT_FILES_PATH = 'topic';

    public function __construct(TopicCommentService $topicCommentService)
    {
        $this->topicCommentService = $topicCommentService;
    }

    public function store(StoreTopicComment $request)
    {
        $topicCommentId = TopicComment::insertGetId([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'text' => $request->text,
            'created_at' => Carbon::now(),
        ]);

        foreach($request->file('files') ?? [] as $file)
        {
            $path = $file->store(self::TOPIC_COMMENT_FILES_PATH);

            File::create([
                'fileable_id' => $topicCommentId,
                'fileable_type' => TopicComment::class,
                'path' => $path
            ]);
        }

        return redirect()->route('topic.get', ['id' => $request->topic_id])
            ->with('comment-create-success', 'Comment has been created successful');
    }

    public function destroy(DestroyTopicComment $request, int $id)
    {
        $topicComment = TopicComment::find($id);

        if($topicComment)
        {
            $this->topicCommentService->destroyFiles($topicComment);
            $topicComment->delete();
        }

        return redirect()
            ->route('topic.get', ['id' => $topicComment->topic->id])
            ->with('topic-comment-delete-success', 'Topic comment has been removed successful');
    }
}
