<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestCategory;

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

        return view('profile.index', compact('user', 'questions', 'tests', 'categories', 'testDates', 'testScores'));
    }
}