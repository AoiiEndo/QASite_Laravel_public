<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;

class TestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tests = Test::with('category')
                    ->where('user_id', $user->id)
                    ->get();
        $categories = TestCategory::where('user_id', $user->id)->get();

        return view('tests.index', compact('tests', 'categories'));
    }

    public function create()
    {
        $categories = TestCategory::all();
        return view('tests.create', compact('categories'));
    }

    public function getCategories()
    {
        $userId = Auth::id();
        $categories = TestCategory::where('user_id', $userId)->get();
        return response()->json([
            'success' => true,
            'category' => $categories
        ]);
    }

    public function storeTest(Request $request)
    {
        $request->validate([
            'test_name' => [
                'required',
                'string',
            ],
            'category_id' => 'required|integer|exists:test_categories,id',
            'test_date' => 'required|date',
            'target_score' => 'required|integer|min:0|max:200',
            'actual_score' => 'nullable|integer|min:0|max:200'
        ]);

        $test = new Test();
        $test->test_name = $request->input('test_name');
        $test->category_id = $request->input('category_id');
        $test->test_date = $request->input('test_date');
        $test->target_score = $request->input('target_score');
        $test->actual_score = $request->input('result_score');
        $test->user_id = Auth::id();
        $test->save();

        return response()->json(['success' => true, 'message' => 'テストが追加されました。', 'test' => $test->load('category')]);
    }

    public function results(Request $request)
    {
        $categoryIds = $request->input('categories');

        $tests = Test::whereIn('category_id', $categoryIds)
                    ->orderBy('test_date', 'asc')
                    ->get();

        $results = [];
        foreach ($tests->groupBy('test_name') as $testName => $testGroup) {
            $results[] = [
                'test_name' => $testName,
                'results' => $testGroup->map(function($test) {
                    return [
                        'date' => $test->test_date,
                        'score' => $test->actual_score
                    ];
                })
            ];
        }

        return response()->json($results);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'test_name' => [
                'required',
                'string',
            ],
            'category_id' => 'required|integer|exists:test_categories,id',
            'test_date' => 'required|date',
            'target_score' => 'required|integer|min:0|max:200',
            'actual_score' => 'nullable|integer|min:0|max:200',
        ]);

        $test = Test::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        $test->test_name = $request->input('test_name');
        $test->category_id = $request->input('category_id');
        $test->test_date = $request->input('test_date');
        $test->target_score = $request->input('target_score');
        $test->actual_score = $request->input('actual_score');
        $test->save();

        return response()->json(['message' => 'テストが更新されました。', 'test' => $test->load('category')]);
    }
}