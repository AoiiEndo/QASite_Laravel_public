@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a New Question</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title<span class="required">*</span></label>
            <input type="text" id="title" name="title" required maxlength="255" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="tags">Tags ("/"で区切ってください。最大5つ。1つにつき15文字以内です。)</label>
            <input type="text" id="tags" name="tags" placeholder="Tags">
            <div id="tag-list"></div>
            <div id="tag-error" style="color: red; display: none;">Please adhere to the tag constraints.</div>
        </div>
        <div class="form-group">
            <label for="content">Content<span class="required">*</span>(LaTeXコードを使用する場合は\$で囲んでください。)</label>
            <textarea id="content" name="content" rows="10" required placeholder="Content"></textarea>
            <div id="preview" class="preview"></div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/questions/questions.js') }}"></script>
@endsection
