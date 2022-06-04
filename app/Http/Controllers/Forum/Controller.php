<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function forum() { /* Przenieś do HomeController */
        $topics = [];

        foreach(User::all() as $user) {
            foreach($user->topics->toArray() as $topic) {
                $topics[] = $topic;
            }
        }

        /* dump(
            User::first()->topics,
            Topic::first()->topicComments,
        ); */
        return view('home', ['topics' => $topics]);
    }
}
