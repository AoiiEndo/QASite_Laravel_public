@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-details">
                    <div class="profile-name-box">
                        <h1>{{ $user->name }}</h1>
                        <p>User ID: {{ $user->id }}</p>
                    </div>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <p class="stat-number">{{ $bestAnswerCount }}</p>
                            <p class="stat-label">ベストアンサー</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">{{ $favoriteExerciseCount }}</p>
                            <p class="stat-label">お気に入り登録</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">{{ $followingCount }}</p>
                            <p class="stat-label">フォロー</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number">{{ $followerCount }}</p>
                            <p class="stat-label">フォロワー</p>
                        </div>
                    </div>
                </div>
                <div class="profile-actions">
                    {{-- <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">プロフィール編集</a> --}}
                </div>
            </div>
            <div id="flash-message" style="display:none;" class="alert alert-success" role="alert"></div>
        </div>
        <div class="profile-actions">
            <a href="#" id="my-questions-btn" class="tab-link active">My Questions</a>
            <a href="#" id="tests-btn" class="tab-link">Tests</a>
            <a href="#" id="my-exercise-btn" class="tab-link">My Exercises</a>
        </div>
        <div class="profile-content" style="background-color: #2b3649; padding: 5%;">
            {{-- 質問一覧タブ --}}
            <div id="question-list" class="tab-content">
                @include('my_questions.index')
            </div>
            {{-- テスト関連タブ --}}
            <div id="tests" class="tab-content" style="display: none;">
                @include('tests.index')
            </div>
            {{-- 演習問題関連タブ --}}
            <div id="exercises-list" class="tab-content" style="display: none;">
                @include('exercises._exercisesProfile')
            </div>
        </div>    
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/tests/tests.js') }}"></script>
@endsection
