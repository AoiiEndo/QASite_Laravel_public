<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Auth;

class TestCategoryController extends Controller
{
    public function index()
    {
        $categories = TestCategory::all();
        return view('test_categories.index', compact('categories'));
    }

    public function show(TestCategory $category)
    {
        return view('test_categories.show', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('test_categories')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id());
                })
            ],
        ]);

        $category = new TestCategory();
        $category->user_id = Auth::id();
        $category->category_name = $request->input('category_name');
        $category->save();

        $categories = TestCategory::where('user_id', Auth::id())
                    ->get();

        return response()->json(['success' => true, 'message' => 'カテゴリが追加されました。', 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('test_categories')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id());
                })
            ],
        ]);
    
        $category = TestCategory::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
        $category->category_name = $request->input('category_name');
        $category->save();

        $test = Test::where('user_id', Auth::id())
                    ->get();
        $categories = TestCategory::where('user_id', Auth::id())
                    ->get();
        return response()->json(['success' => true, 'message' => 'カテゴリが更新されました。', 'test' => $test->load('category'), 'categories' => $categories]);
    }

    public function destroy(TestCategory $category)
    {
        try {
            $category->delete();
            return redirect()->route('test-categories.index')->with('success', 'カテゴリが削除されました。');
        } catch (\Exception $e) {
            return redirect()->route('test-categories.index')->with('error', $e->getMessage());
        }
    }
}
