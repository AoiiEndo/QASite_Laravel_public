@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Exercises</h1>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createExerciseModal">演習問題作成</button>
        </div>
        <form action="{{ route('exercises.search') }}" method="POST">
            @csrf
            <input type="text" name="query" placeholder="Search by title" value="{{ old('query', $query ?? '') }}">
            <button type="submit">Search</button>
        </form>
        @include('exercises._list')
    </div>
@endsection
@include('exercises._modals')
@section('scripts')
    <script src="{{ asset('js/exercises/exercises.js') }}"></script>
@endsection