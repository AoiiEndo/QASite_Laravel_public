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

@section('styles')
<style>
    .resolved {
        border-color: gold;
    }
    .profile-header {
        background-color: #2b3649;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-name-box {
        margin-bottom: 20px;
    }

    .profile-name-box h1 {
        margin: 0;
        font-size: 36px;
        color: #fff;
    }

    .profile-name-box p {
        margin: 0;
        font-size: 16px;
        color: #d5dce3;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 50px;
        margin-top: 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    .stat-label {
        font-size: 14px;
        color: #d5dce3;
    }

    #flash-message {
        margin-top: 20px;
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

    .profile-actions {
        margin-bottom: 20px;
    }

    .tab-link {
        display: inline-block;
        padding: 10px 20px;
        margin-right: 10px;
        text-decoration: none;
        color: #fff;
        border-radius: 5px;
        border: 1px solid transparent;
        transition: background-color 0.3s, color 0.3s, border-bottom 0.3s;
    }

    .tab-link:hover,
    .tab-link.active {
        background-color: limegreen;
        color: #fff;
        border-bottom: 2px solid #007bff;
        border-radius: 5px;
    }

    .tab-link.active {
        border-bottom: 2px solid #007bff;
    }
    .tabs {
        margin-bottom: 20px;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem;
    }
</style>
@endsection
@section('scripts')
    <script src="{{ asset('js/tests/tests.js') }}"></script>
@endsection
