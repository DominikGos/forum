<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\Controller as BasicController;
use App\Http\Requests\SearchTopic;
use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;
use App\Models\Topic;
use App\Models\TopicFile;
use App\Services\TopicCommentService;
use App\Services\TopicService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Controller extends BasicController
{
    private TopicService $topicService;
    private TopicCommentService $topicCommentService;
    private const TOPIC_FILES_PATH = 'topic';

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
        )->get();

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
            'update-topic',
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

        $topic->name = $request->name ?? $topic->name;
        $topic->text = $request->text ?? $topic->text;
        $topic->updated = true;
        $topic->updated_at = Carbon::now();

        $topic->save();

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
        $topicId = Topic::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'text' => $request->text,
            'created_at' => Carbon::now()
        ]);

        foreach($request->file('files') ?? [] as $file) {
            $path = $file->store(self::TOPIC_FILES_PATH);

            TopicFile::create([
                'topic_id' => $topicId,
                'user_id' => Auth::id(),
                'path' => $path
            ]);
        }

        return redirect()->route('home')->with('topic-create-success', 'The thread has been created successful');
    }

    public function destroy(int $id)
    {
        Gate::authorize(
            'delete-topic',
            $topic = Topic::find($id)
        );

        if($topic)
        {
            foreach($topic->topicComments as $comment) {
                $this->topicCommentService->destroyFiles($comment);
            }

            $this->topicService->destroyFiles($topic);
        }

        return redirect()
            ->route('home')
            ->with('topic-delete-success', 'Topic has been removed successful');
    }

    public function search(SearchTopic $request)
    {
        $searchedTopicName = $request->name;

        $topics = [];

        $topics = Topic::where('name', 'like', "%$searchedTopicName%")->get();

        return view('topic.list', [
            'topics' => $topics,
            'numberOfTopics' => count($topics)
        ]);
    }
}

