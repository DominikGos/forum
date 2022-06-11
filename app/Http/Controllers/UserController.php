<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Models\Topic;
use App\Models\TopicComment;
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
            $userComments = TopicComment::where('user_id', $id)->get();
        }

        return view('user.profile', [
            'user' => $user,
            'dataToDisplay' => $dataToDisplay,
            'userComments' => $userComments
        ]);
    }

    public function edit(int $id)
    {
        $user = User::find($id);

        return view('user.profile-edit', ['user' => $user]);
    }

    public function update(UpdateProfile $request, int $id)
    {
        $user = User::find($id);

        if($request->avatar) {
            $avatarPath = $request->file('avatar')->store('avatar');
        }

        $user->name = $request->name ?? $user->name;
        $user->avatar = $avatarPath ?? $user->avatar;

        $user->save();

        return redirect()
            ->route('profile', ['id' => $user->id])
            ->with('profile-update-success', 'Profile has been updated successful');
    }
}
