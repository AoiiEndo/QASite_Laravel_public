@extends('layouts.app')

@section('content')
<div class="container">
    <div class="question-detail">
        <h1>{{ $question->title }}</h1>
        <div class="tags">
            @foreach($question->tags as $tag)
                <span class="tag">{{ $tag }}</span>
            @endforeach
        </div>
        <div class="meta">
            <span>{{ $question->created_at->diffForHumans() }}</span>
            <span>{{ $question->user->name }}</span>
        </div>
        <hr style="border:none;border-top:dashed 2px;height:1px;margin:20px 0;">
        <div class="content">
            {!! preg_replace('/\$(.*?)\$/', '\\( $1 \\)', $question->content) !!}
        </div>
    </div>

    @foreach($question->answers as $answer)
        <div class="answer {{ $question->best_answer_id == $answer->id ? 'best' : '' }}">
            <p>{{ $answer->content }}</p>
            <div class="meta">
                <span>{{ $answer->created_at->diffForHumans() }}</span>
                <span>{{ $answer->user->name }}</span>
                @if($question->user_id == auth()->id() && $question->best_answer_id != $answer->id && !isset($question->best_answer_id))
                    <form action="{{ route('answers.best', $answer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">ベストアンサー</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
    @if(!isset($question->best_answer_id))
        <div class="answer-form">
            <form action="{{ route('answers.store', $question->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">回答を入力してください</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">回答を投稿</button>
            </form>
        </div>
    @endif
</div>
@endsection

@section('styles')
    <style>
        .question-detail, .answer, .answer-form {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #2b3649;
        }
        .tags .tag {
            display: inline-block;
            background-color: #4a5568;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            margin-right: 5px;
        }
        .meta span {
            margin-right: 50px;
        }
        .best {
            border-color: gold;
        }
        .content {
            border: 1px solid #4a5568;
            padding: 10px;
            background: #1a202c;
            overflow: auto;
            white-space: pre-line;
            width: calc(100% - 20px);
            border-radius: 5px;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    <script src="{{ asset('js/questions/questionShow.js') }}"></script>
@endsection