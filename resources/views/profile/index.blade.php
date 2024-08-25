@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="profile-header">
            <div class="profile-info">
                <div class="profile-name">
                    <div>
                        <h1>Profile</h1>
                    </div>
                    <div id="flash-message" style="display:none;" class="alert alert-success" role="alert"></div>
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
        <div class="profile-actions">
            <a href="#" id="my-questions-btn" class="tab-link active">My Questions</a>
            <a href="#" id="tests-btn" class="tab-link">Tests</a>
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
