<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\ExerciseFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    // 一覧表示
    public function index() {
        $questions = Question::orderBy('created_at', 'desc')->paginate(25);
        $followedUserIds = Auth::check() ? Auth::user()->follows->pluck('followed_user_id')->toArray() : [];

        $favoriteExerciseIds = [];

        if (Auth::check()) {
            $favoriteExercisesRecord = ExerciseFavorite::where('user_id', Auth::id())->first();

            if ($favoriteExercisesRecord && !empty($favoriteExercisesRecord->exercises_id)) {
                $favoriteExerciseIds = json_decode($favoriteExercisesRecord->exercises_id, true);
            }
        }
    
        return view('questions.index', [
            'questions' => $questions,
            'followedUserIds' => $followedUserIds,
            'favoriteExerciseIds' => $favoriteExerciseIds
        ]);
    }

    // 質問作成画面遷移
    public function create() {
        return view('questions.create');
    }

    // 質問登録
    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $tags = explode('/', $request->input('tags'));
        if (count($tags) > 5) {
            return back()->withErrors(['tags' => 'タグは5つまでです。'])->withInput();
        }
        foreach ($tags as $tag) {
            if (strlen($tag) > 15) {
                return back()->withErrors(['tags' => '1つのタグは15文字までです。'])->withInput();
            }
        }

        $question = new Question();
        $question->title = $validatedData['title'];
        $question->tags = $tags;
        $question->content = $validatedData['content'];
        $question->user_id = Auth::id();
        $question->save();

        return redirect()->route('questions.index')->with('success', 'Question posted successfully.');
    }

    // 質問の詳細
    public function show($id)
    {
        $question = Question::with('answers')->findOrFail($id);
        return view('questions.show', compact('question'));
    }

    // 質問への回答
    public function answer(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $answer = new Answer();
        $answer->content = $validatedData['content'];
        $answer->question_id = $id;
        $answer->user_id = auth()->id();
        $answer->save();

        return redirect()->route('questions.show', ['id' => $id])->with('success', 'Answer posted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $questions = Question::where('title', 'like', "%$query%")
                            ->orWhereJsonContains('tags', $query)
                            ->orderBy('created_at', 'desc')
                            ->paginate(25);

        $followedUserIds = Auth::check() ? Auth::user()->follows->pluck('followed_user_id')->toArray() : [];

        return view('questions.index', compact('questions', 'query', 'followedUserIds'));
    }
}
