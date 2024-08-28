<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();
        $followedUserId = $request->input('user_id');

        $existingFollow = Follow::where('user_id', $userId)
                            ->where('followed_user_id', $followedUserId)
                            ->first();

        if ($existingFollow) {
            return response()->json(['message' => '既に登録済みです。'], 400);
        }

        Follow::create([
            'user_id' => $userId,
            'followed_user_id' => $followedUserId,
        ]);

        return response()->json(['success' => true, 'message' => 'フォローしました。']);
    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();
        $followedUserId = $request->input('user_id');

        Follow::where('user_id', $userId)
              ->where('followed_user_id', $followedUserId)
              ->delete();

        return response()->json(['success' => true, 'message' => 'フォローをやめました。']);
    }

    public function getFollowing()
    {
        $userId = Auth::id();
        $following = Follow::where('user_id', $userId)
                           ->with('followedUser')
                           ->get();

        return response()->json($following);
    }

    public function getFollowers()
    {
        $userId = Auth::id();
        $followers = Follow::where('followed_user_id', $userId)
                           ->with('user')
                           ->get();

        return response()->json($followers);
    }
}
