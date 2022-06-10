<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function get(Request $request, int $id)
    {
        $user = User::find($id);

        $userComments = [];

        $availableData = [
            'threads',
            'comments'
        ];

        $dataToDisplay = $request->get('data-to-display');

        if( ! in_array($dataToDisplay, $availableData)) $dataToDisplay = $availableData[0];

        if($dataToDisplay === $availableData[1]) {
            foreach(Topic::with('user')->get() as $topic) {
                if(
                    count( $comments = $topic->topicComments->where('user_id', Auth::id())) > 0
                ) {
                    foreach($comments as $comment) {
                        $userComments[] = $comment;
                    }
                }
            }
        }

        return view('user.profile', [
            'user' => $user, 'dataToDisplay' => $dataToDisplay, 'userComments' => $userComments
        ]);
    }

    public function edit(int $id)
    {
        $user = User::find($id);

        return view('user.profile-edit', ['user' => $user]);
    }

    
}
