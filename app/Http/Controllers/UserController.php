<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Models\Topic;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function get(Request $request, int $id)
    {
        $user = User::with(['topics.user', 'topics.topicFiles'])->find($id);

        $userComments = [];

        $availableData = [
            'threads',
            'comments'
        ];

        $dataToDisplay = $request->get('data-to-display');

        if( ! in_array($dataToDisplay, $availableData)) $dataToDisplay = $availableData[0];

        if($dataToDisplay === $availableData[1]) {
            $userComments = TopicComment::with(['user', 'topicCommentFiles', 'topic'])->where('user_id', $id)->get();
        }

        return view('user.get', [
            'user' => $user,
            'dataToDisplay' => $dataToDisplay,
            'userComments' => $userComments
        ]);
    }

    public function edit(int $id)
    {
        Gate::authorize(
            'update-profile',
            $user = User::find($id)
        );

        return view('user.edit', ['user' => $user]);
    }

    public function update(UpdateProfile $request, int $id)
    {
        Gate::authorize(
            'update-profile',
            $user = User::find($id)
        );

        if($request->avatar) {
            $avatarPath = $request->file('avatar')->store('avatar');
        }

        $user->name = $request->name ?? $user->name;
        $user->avatar = $avatarPath ?? $user->avatar;

        $user->save();

        return redirect()
            ->route('user.get', ['id' => $user->id])
            ->with('profile-update-success', 'Profile has been updated successful');
    }

    public function list()
    {
        $users = User::all();

        return view('user.list', ['users' => $users]);
    }
}
