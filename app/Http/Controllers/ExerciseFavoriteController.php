<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class ExerciseFavoriteController extends Controller
{

    public function index()
    {
        $favoriteExercises = Auth::user()->favoriteExercises;
        return view('exercises.favorite', compact('favoriteExercises'));
    }

    public function toggleFavorite(Request $request)
    {
        Log::info($request);
        $userId = auth()->id();
        $exerciseId = $request->input('exercise_id');

        $favorite = ExerciseFavorite::where('user_id', $userId)->first();

        if (!$favorite) {
            $favorite = ExerciseFavorite::create([
                'user_id' => $userId,
                'exercises_id' => json_encode([$exerciseId])
            ]);
        } else {
            $exercisesIds = json_decode($favorite->exercises_id, true) ?: [];

            if (!in_array($exerciseId, $exercisesIds)) {
                $exercisesIds[] = $exerciseId;
            } else {
                $exercisesIds = array_diff($exercisesIds, [$exerciseId]);
            }

            $favorite->exercises_id = json_encode(array_values($exercisesIds));
            $favorite->save();
        }

        return response()->json(['success' => true, 'message' => 'お気に入りの状態が更新されました。']);
    }
}
