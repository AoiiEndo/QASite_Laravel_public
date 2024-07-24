<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $answer = new Answer;
        $answer->content = $request->content;
        $answer->user_id = Auth::id();
        $answer->question_id = $id;
        $answer->save();

        return redirect()->route('questions.show', $id)->with('success', 'Answer posted successfully');
    }

    public function markAsBest($id)
    {
        $answer = Answer::findOrFail($id);
        $question = $answer->question;

        // 質問の投稿者のみがベストアンサーを選択できる
        if ($question->user_id === Auth::id()) {
            $question->best_answer_id = $answer->id;
            $question->save();

            return redirect()->route('questions.show', $question->id)->with('success', 'Marked as best answer');
        }

        return redirect()->route('questions.show', $question->id)->with('error', 'Only the question owner can mark the best answer');
    }
}
