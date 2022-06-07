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

        $defaultData = $availableData[0];

        $dataToDisplay = $request->get('data-to-display');

        if( ! in_array($dataToDisplay, $availableData)) $dataToDisplay = $defaultData;

        if($dataToDisplay === $availableData[1]) {
            foreach(Topic::with('author')->get() as $topic) {
                if(
                    count( $comments = $topic->comments->where('user_id', Auth::id())) > 0
                ) {
                    foreach($comments as $comment) {
                        $userComments[] = $comment;
                    }
                }
            }
        }

        return view('profile', [
            'user' => $user, 'dataToDisplay' => $dataToDisplay, 'userComments' => $userComments
        ]);
    }
}
