@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h2 style="text-align: center; margin-bottom: 20px;">お問い合わせ</h2>
    <form method="POST" action="{{ route('contact.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="inquiry_type">お問い合わせ</label>
            <select id="inquiry_type" name="inquiry_type" class="form-control" required>
                <option value="">選択してください</option>
                <option value="0">プライバシーポリシーについて</option>
                <option value="1">運営者について</option>
                <option value="2">その他</option>
            </select>
        </div>

        <div class="form-group">
            <label for="message">お問い合わせ内容</label>
            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn" style="background-color: #5fbc07;">送信</button>
    </form>
</div>
@endsection
