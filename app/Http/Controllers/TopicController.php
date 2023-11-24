<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BasicController;
use App\Http\Requests\SearchTopicRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use App\Services\TopicCommentService;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TopicController extends BasicController
{
    private TopicService $topicService;
    private TopicCommentService $topicCommentService;
    private const TOPICS_PER_PAGE = 10;

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
        )->paginate(self::TOPICS_PER_PAGE);

        return view('topic.list', [
            'topics' => $topics,
            'numberOfTopics' => $topics->count()
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

    public function update(UpdateTopicRequest $request, int $id)
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

    public function store(StoreTopicRequest $request)
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

    public function search(SearchTopicRequest $request)
    {
        $searchedTopicName = $request->name;

        $topics = [];

        $topics = Topic::where('name', 'like', "%$searchedTopicName%")->paginate(self::TOPICS_PER_PAGE);

        return view('topic.list', [
            'topics' => $topics,
            'numberOfTopics' => $topics->total()
        ]);
    }
}

