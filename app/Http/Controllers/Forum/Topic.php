<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopic;
use App\Http\Requests\UpdateTopic;
use Illuminate\Http\Request;
use App\Models\Topic as ModelTopic;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Topic extends Controller
{
    public function list()
    {
        $topics = ModelTopic::with('author')->get();

        return view('topic-list', [
            'topics' => $topics,
            'numberOfTopics' => count($topics)
        ]);
    }

    public function get(int $id)
    {
        $topic = ModelTopic::find($id);

        $numberOfComments = $topic->comments->count();

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
        ModelTopic::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'text' => $request->text
        ]);

        return redirect()->route('topic.list');
    }
}
