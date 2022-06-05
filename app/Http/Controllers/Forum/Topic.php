<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTopic;
use Illuminate\Http\Request;
use App\Models\Topic as ModelTopic;
use Carbon\Carbon;
use App\Models\User;

class Topic extends Controller
{
    public function all()
    {
        $topics = [];

        foreach(User::all() as $user) {
            foreach($user->topics as $topic) {
                $topics[] = $topic;
            }
        }

        return view('topic-list', ['topics' => $topics]);
    }

    public function get(int $id)
    {
        $topic = ModelTopic::find($id);

        return view('topic', ['topic' => $topic]);
    }

    public function edit(int $id)
    {
        return view('topic-edit', ['id' => $id]);
    }

    public function create()
    {
        return view('topic-create');
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
}
