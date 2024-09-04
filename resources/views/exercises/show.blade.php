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
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('js/exercises/exerciseShow.js') }}"></script>
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endsection

