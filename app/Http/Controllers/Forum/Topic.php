<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Topic as ModelTopic;
use Illuminate\Http\Request;

class Topic extends Controller
{
    public function get(int $id)
    {
        $topic = ModelTopic::find($id);

        dump($topic);

        return view('topic', ['topic' => $topic]);
    }
}
