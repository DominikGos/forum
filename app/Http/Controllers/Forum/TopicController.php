<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;
use App\Models\Topic as ModelTopic;
use App\Models\TopicComment;
use App\Models\TopicFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function list()
    {
        $topics = ModelTopic::with('user')->get();

        //dump(ModelTopic::find(22)->topicFiles);

        return view('topic-list', [
            'topics' => $topics,
            'numberOfTopics' => count($topics)
        ]);
    }

    public function get(int $id)
    {
        $topic = ModelTopic::with('user')->find($id);

        $numberOfComments = $topic->topicComments->count();

        return view('topic', [
            'topic' => $topic,
            'numberOfComments' => $numberOfComments
        ]);
    }

    public function edit(int $id)
    {
        return view('topic-edit', ['id' => $id]);
    }

    public function update(UpdateTopic $request)
    {
        $topic = ModelTopic::find($request->id);

        $topic->name = $request->name ?? $topic->name;
        $topic->text = $request->text ?? $topic->text;
        $topic->updated_at = Carbon::now();

        $topic->save();

        return redirect()->route('topic.get', ['id' => $request->id]);
    }

    public function create()
    {
        return view('topic-create');
    }

    public function store(StoreTopic $request)
    {
        $topicId = ModelTopic::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'text' => $request->text
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
}
