<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTopic;
use App\Http\Requests\SearchTopic;
use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;
use App\Models\Topic;
use App\Models\TopicComment;
use App\Models\TopicFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TopicController extends Controller
{
    public function list(Request $request)
    {
        $sequence = $request->get('order');

        $accessibleSequences = [
            'desc',
            'asc',
        ];

        if( ! in_array($sequence, $accessibleSequences)) $order = $accessibleSequences[0];

        $topics = Topic::orderBy('id', $order)->get();

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
            $path = $file->store('topic');

            TopicFile::create([
                'topic_id' => $topicId,
                'user_id' => Auth::id(),
                'path' => $path
            ]);
        }

        return redirect()->route('topic.list')->with('topic-create-success', 'The thread has been created successful');
    }

    public function destroy(DestroyTopic $request, int $id)
    {
        Gate::authorize(
            'delete-topic',
            $topicToDestroy = Topic::find($id)
        );

        if($topicToDestroy) {
            //zrób usuwanie plików

            foreach($topicToDestroy->topicComments as $comment) {
                $comment->delete();
            }

            $topicToDestroy->delete();
        }

        return redirect()
            ->route('topic.list')
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

