@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header">
        <div class="profile-info">
            <div class="profile-name">
                <div>
                    <h1>Profile</h1>
                </div>
                <div class="profile-name-box">
                    <h3> {{ $user->name }}</h3>
                </div>
                <div>
                    <h3>{{ $user->id }}</h3>
                </div>
            </div>
            {{-- <div class="profile-actions">
                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">プロフィール編集</a>
            </div> --}}
        </div>
    </div>
    <h2>My Questions</h2>
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
                    <span>{{ $user->name }}</span>
                    {{-- {{ $question->user->name }} --}}
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
    .profile-header {
        background-color: #2b3649;;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    .profile-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .profile-name {
        padding: 10px;
    }
    .profile-name h1 {
        margin: 0;
    }
    .profile-actions {
        margin-left: 20px;
    }
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        text-decoration: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection
@section('scripts')
@endsection
