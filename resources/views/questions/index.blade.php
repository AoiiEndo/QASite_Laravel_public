@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Questions</h1>
    <form action="{{ route('questions.search') }}" method="POST">
        @csrf
        <input type="text" name="query" placeholder="Search by tag or title" value="{{ old('query', $query ?? '') }}">
        <button type="submit">Search</button>
    </form>
    <div id="question-list">
        @foreach($questions as $question)
            <div class="question {{ !is_null($question->best_answer_id) ? 'resolved' : '' }}" id="question-{{ $question->id }}" onclick="location.href='{{ route('questions.show', ['id' => $question->id]) }}'">
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
                    <span>{{ $question->user->name }}</span>
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
