@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Questions</h1>
    @if (!auth()->check())
        <h5 style="color: #fe0505">※ログインしないと質問の作成や回答、テスト管理などの機能は使用できません。</h5>
    @endif
    <form action="{{ route('questions.search') }}" method="POST">
        @csrf
        <input type="text" name="query" placeholder="Search by tag or title" value="{{ old('query', $query ?? '') }}">
        <button type="submit">Search</button>
    </form>
    <div id="question-list">
        @foreach($questions as $question)
        <div class="question {{ !is_null($question->best_answer_id) ? 'resolved' : '' }}" id="question-{{ $question->id }}" data-href="{{ route('questions.show', ['id' => $question->id]) }}">
                <div class="question-header">
                    <h2>{{ $question->title }}</h2>
                    <div class="tags">
                        @foreach($question->tags as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="info">
                    <span class="created-at" data-timestamp="{{ $question->created_at }}">{{ $question->created_at->diffForHumans() }}</span>
                    @if(in_array($question->user->id, $followedUserIds))
                        <span class="followed-user">
                            {{ $question->user->name }}
                            <span style="color:#fe0505">&hearts;</span>
                        </span>
                    @else
                        <span class="followed-user">
                            {{ $question->user->name }}
                            <span style="color:#fdfdfd">&hearts;</span>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .resolved {
        border-color: gold;
    }
</style>
@endsection
@section('scripts')
<script src="{{ asset('js/questions/questionIndex.js') }}"></script>
@endsection
