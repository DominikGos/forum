<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\Controller as BasicController;
use App\Http\Requests\SearchTopic;
use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;
use App\Models\File;
use App\Models\Topic;
use App\Services\TopicCommentService;
use App\Services\TopicService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Controller extends BasicController
{
    private TopicService $topicService;
    private TopicCommentService $topicCommentService;
    private static  $topicsPerPage = 10;

    public function __construct(TopicService $topicService, TopicCommentService $topicCommentService)
    {
        $this->topicService = $topicService;
        $this->topicCommentService = $topicCommentService;
    }

    public function list(Request $request)
    {
        $topics = Topic::orderBy(
            'id',
            $this->topicService->listSequence($request->get('sequence'))
        )->paginate(self::$topicsPerPage);

        return view('topic.list', [
            'topics' => $topics,
            'numberOfTopics' => count($topics)
        ]);
    }

    public function get(int $id)
    {
        $topic = Topic::find($id);

        $numberOfComments = 0;

        if($topic) {
            $numberOfComments = $topic->topicComments->count();
        }

        return view('topic.get', [
            'topic' => $topic,
            'numberOfComments' => $numberOfComments
        ]);
    }

    public function edit(int $id)
    {
        Gate::authorize(
            'updateTopic',
            $topic = Topic::find($id)
        );

        return view('topic.edit', ['topic' => $topic]);
    }

    public function update(UpdateTopic $request, int $id)
    {
        Gate::authorize(
            'update-topic',
            $topic = Topic::find($id)
        );

        $this->topicService->update($topic, $request->all());

        return redirect()
            ->route('topic.get', ['id' => $id])
            ->with('topic-update-success', 'Topic has been updated successful.');
    }

    public function create()
    {
        return view('topic.create');
    }

    public function store(StoreTopic $request)
    {
        $this->topicService->store($request->all());

        return redirect()->route('home')->with('topic-create-success', 'The thread has been created successful');
    }

    public function destroy(int $id)
    {
        Gate::authorize(
            'deleteTopic',
            $topic = Topic::find($id)
        );

        if($topic)
        {
            foreach($topic->topicComments as $comment) {
                $this->topicCommentService->destroyForumResource($comment);
            }

            $this->topicService->destroyForumResource($topic);
        }

        return redirect()
            ->route('home')
            ->with('topic-delete-success', 'Topic has been removed successful');
    }

    public function search(SearchTopic $request)
    {
        $searchedTopicName = $request->name;

        $topics = [];

        $topics = Topic::where('name', 'like', "%$searchedTopicName%")->paginate(self::$topicsPerPage);

        return view('topic.list', [
            'topics' => $topics,
            'numberOfTopics' => count($topics)
        ]);
    }
}

