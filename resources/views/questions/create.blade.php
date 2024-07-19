@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a New Question</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title <span class="required">*</span></label>
            <input type="text" id="title" name="title" required maxlength="255">
        </div>
        <div class="form-group">
            <label for="tags">Tags (separate with /, max 5 tags, 15 chars each)</label>
            <input type="text" id="tags" name="tags" placeholder="Enter tags separated by /">
            <div id="tag-list"></div>
            <div id="tag-error" style="color: red; display: none;">Please adhere to the tag constraints.</div>
        </div>
        <div class="form-group">
            <label for="content">Content <span class="required">* </span>(Enter your content here. You can use LaTeX for math: \$ ... \$ or \$\$ ... \$\$)</label>
            <textarea id="content" name="content" rows="10" required></textarea>
            <div id="preview"></div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/questions/questions.js') }}"></script>
@endsection
