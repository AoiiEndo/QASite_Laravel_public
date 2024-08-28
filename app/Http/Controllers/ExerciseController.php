<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class ExerciseController extends Controller
{

    public function index()
    {
        $exercises = Exercise::public()->orderBy('created_at', 'desc')->get();
        return view('exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'public_status' => 'nullable|boolean',
        ]);
    
        $publicStatus = $request->input('public_status', 0);
    
        $exercise = Exercise::create([
            'title' => $request->input('title'),
            'contents' => $request->input('content'),
            'public_status' => $publicStatus,
            'user_id' => auth()->id(),
        ]);
        
        return response()->json(['success' => true, 'message' => '演習問題が作成されました。']);
    }

    public function getExercises()
    {
        $user = auth()->user();
        $exercises = Exercise::public()
                    ->with('user')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();

        return response()->json([
            'success' => true,
            'exercises' => $exercises,
        ]);
    }

    public function edit(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            return redirect()->route('exercises.index')->with('error', '編集権限がありません。');
        }

        return view('exercises.edit', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            return redirect()->route('exercises.index')->with('error', '更新権限がありません。');
        }

        $request->validate([
            'contents' => 'required|max:5000',
            'public_status' => 'required|boolean',
        ]);

        $exercise->update([
            'contents' => $request->contents,
            'public_status' => $request->public_status,
        ]);

        return redirect()->route('exercises.index')->with('success', '演習問題が更新されました。');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $exercises = Exercise::where('title', 'LIKE', '%' . $query . '%')
            ->with('user')
            ->get();

        return view('exercises.index', compact('exercises', 'query'));
    }

    public function show($id)
    {
        $exercise = Exercise::with('user')->findOrFail($id);

        return view('exercises.show', compact('exercise'));
    }

    public function destroy(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            return redirect()->route('exercises.index')->with('error', '削除権限がありません。');
        }

        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', '演習問題が削除されました。');
    }
}