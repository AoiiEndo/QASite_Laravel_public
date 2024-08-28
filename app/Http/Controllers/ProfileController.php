<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestCategory;
use App\Models\Exercise;
use App\Models\ExerciseFavorite;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $questions = $user->questions()->latest()->get();
        $tests = $user->tests()->with('category')->latest()->get();
        $categories = TestCategory::where('user_id', $user->id)->get();

        $testDates = $tests->pluck('test_date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
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

        $bestAnswerCount = \App\Models\Question::where('best_answer_id', $user->id)->count();

        $favoriteExerciseCount = \App\Models\ExerciseFavorite::where('user_id', $user->id)
            ->get()
            ->map(function ($favorite) {
                return count(json_decode($favorite->exercises_id, true));
            })->sum();

        return view('profile.index', compact('user',
                                            'questions',
                                            'tests',
                                            'categories',
                                            'testDates',
                                            'testScores',
                                            'exercises',
                                            'favoriteExercises',
                                            'bestAnswerCount',
                                            'favoriteExerciseCount'
                                        ));
    }
}