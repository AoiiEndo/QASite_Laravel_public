@extends('layouts.app')

@section('content')
<div class="container">
    <div class="exercise-header">
        <h1>{{ $exercise->title }}</h1>
        <p><strong>作成者:</strong> {{ $exercise->user->name }}</p>
        <p><strong>最終更新日:</strong> {{ $exercise->updated_at->format('Y-m-d H:i:s') }}</p>
        @if (auth()->id() !== $exercise->user_id)
            <div class="favorite-container" style="padding: 10px;">
                <form id="favorite-form" style="display: inline;">
                    @csrf
                    <input type="hidden" name="exercise_id" id="exercise-id" value="{{ $exercise->id }}">
                </form>
                @php
                    $favorite = \App\Models\ExerciseFavorite::where('user_id', auth()->id())->first();
                    $isFavorited = $favorite && in_array($exercise->id, json_decode($favorite->exercises_id, true));
                @endphp
                <button id="favorite-btn" class="favorite-btn {{ $isFavorited ? 'favorited' : '' }}" data-exercise-id="{{ $exercise->id }}" style="color:#fff;">
                    お気に入り登録 
                    <i class="favorite-icon fas {{ $isFavorited ? 'fa-star' : 'fa-star-o' }}"></i>
                </button>
                @if (auth()->check() && auth()->id() !== $exercise->user_id)
                    <div class="follow-buttons">
                        @php
                            $isFollowing = \App\Models\Follow::where('user_id', auth()->id())
                                                            ->where('followed_user_id', $exercise->user_id)
                                                            ->exists();
                        @endphp
                        @if ($isFollowing)
                            <form id="unfollow-form" method="POST" action="{{ route('follow.unfollow') }}" style="display:block; padding: 0!important;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $exercise->user_id }}">
                                <button type="submit" id="unfollow-btn">フォローをやめる</button>
                            </form>
                            <form id="follow-form" method="POST" action="{{ route('follow.follow') }}" style="display:none; padding: 0!important;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $exercise->user_id }}">
                                <button type="submit" id="follow-btn">フォローする</button>
                            </form>
                        @else
                            <form id="unfollow-form" method="POST" action="{{ route('follow.unfollow') }}" style="display:none; padding: 0!important;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $exercise->user_id }}">
                                <button type="submit" id="unfollow-btn">フォローをやめる</button>
                            </form>
                            <form id="follow-form" method="POST" action="{{ route('follow.follow') }}" style="display:block; padding: 0!important;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $exercise->user_id }}">
                                <button type="submit" id="follow-btn">フォローする</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
    <div class="exercise-content p-4 mt-4">
        <h2>内容</h2>
        <div id="exercise-content" class="latex-content">
            {!! nl2br(preg_replace('/\$(.*?)\$/s', '\\( $1 \\)', e($exercise->contents))) !!}
        </div>
    </div>
</div>
@endsection
@section('styles')
    <style>
        .container {
            margin-top: 20px;
        }

        .exercise-header {
            background-color: #2b3649;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .exercise-content {
            background-color: #2b3649;
            border: 1px solid #2b3649;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            margin-bottom: 10px;
        }

        .exercise-header p {
            margin: 0;
            font-size: 14px;
            color: #d5dce3;
        }

        .latex-content {
            background-color: #1a202c;
            border: 1px solid #1a202c;
            border-radius: 5px;
            margin: 10px 0;
            padding: 20px;
        }

        .favorite-container {
            position: relative;
            display: inline-block;
        }

        .favorite-btn {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 0;
        }

        .favorite-icon {
            font-size: 24px;
            color: #ccc;
            transition: transform 0.3s ease, color 0.3s ease;
            display: inline-block;
        }

        .favorite-btn.favorited .favorite-icon {
            color: #ffd700;
            transform: rotate(360deg);
        }

        .favorite-icon::before {
            content: '\2605';
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('js/exercises/exerciseShow.js') }}"></script>
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endsection

