<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TestCategory;
use App\Models\Exercise;
use App\Models\ExerciseFavorite;
use App\Models\Follow;
use App\Models\Question;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $questions = $user->questions()->latest()->get();
        $tests = $user->tests()->with('category')->latest()->get();
        $categories = TestCategory::where('user_id', $user->id)->get();

        $testDates = $tests->pluck('test_date')->map(function($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->toArray();
    
        $testScores = $tests->pluck('actual_score')->toArray();

        $exercises = Exercise::with('user')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();

        $favoriteExercisesRecord = ExerciseFavorite::where('user_id', $user->id)->first();

        $favoriteExercises = collect();
        if ($favoriteExercisesRecord && $favoriteExercisesRecord->exercises_id) {
            $exerciseIds = json_decode($favoriteExercisesRecord->exercises_id, true);

            if (!empty($exerciseIds)) {
                $favoriteExercises = Exercise::with('user')
                                    ->whereIn('id', $exerciseIds)
                                    ->latest()
                                    ->get();
            }
        }

        $bestAnswerCount = Question::where('best_answer_id', $user->id)->count();

        $favoriteExerciseCount = ExerciseFavorite::where('user_id', $user->id)
            ->get()
            ->map(function ($favorite) {
                return count(json_decode($favorite->exercises_id, true));
            })->sum();

        $followedUserIds = Auth::check() ? Auth::user()->follows->pluck('followed_user_id')->toArray() : [];
        $followingCount = Auth::user()->follows()->count();
        $followerCount = Follow::where('followed_user_id', $user->id)->count();

        $favoriteExerciseIds = [];

        if (Auth::check()) {
            $favoriteExercisesRecord = ExerciseFavorite::where('user_id', Auth::id())->first();

            if ($favoriteExercisesRecord && !empty($favoriteExercisesRecord->exercises_id)) {
                $favoriteExerciseIds = json_decode($favoriteExercisesRecord->exercises_id, true);
            }
        }


        return view('profile.index', compact('user',
                                            'questions',
                                            'tests',
                                            'categories',
                                            'testDates',
                                            'testScores',
                                            'exercises',
                                            'favoriteExercises',
                                            'bestAnswerCount',
                                            'favoriteExerciseCount',
                                            'followedUserIds',
                                            'followingCount',
                                            'followerCount',
                                            'favoriteExerciseIds'
                                        ));
    }
}