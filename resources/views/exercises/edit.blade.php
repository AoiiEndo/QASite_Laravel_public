@extends('layouts.app')

@section('content')
<div class="container">
    <h1>演習問題の編集</h1>

    <form action="{{ route('exercises.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="contents" class="form-label">内容</label>
            <textarea class="form-control @error('contents') is-invalid @enderror" id="contents" name="contents" rows="10">{{ old('contents', $exercise->contents) }}</textarea>
            @error('contents')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="public_status" class="form-label">公開ステータス</label>
            <select class="form-select @error('public_status') is-invalid @enderror" id="public_status" name="public_status">
                <option value="1" {{ old('public_status', $exercise->public_status) == 1 ? 'selected' : '' }}>公開</option>
                <option value="0" {{ old('public_status', $exercise->public_status) == 0 ? 'selected' : '' }}>非公開</option>
            </select>
            @error('public_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
