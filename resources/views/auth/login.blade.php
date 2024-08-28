<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-bg">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 20px;">ログイン</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <div class="label-with-line">
                    <label for="email">メールアドレス</label>
                </div>
                <input id="email" type="email" name="email" class="form-control" required autocomplete="email" autofocus>
            </div>

            <div class="form-group">
                <div class="label-with-line">
                    <label for="password">パスワード</label>
                </div>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn">ログイン</button>
        </form>
        <a href="{{ route('register') }}" class="btn">新規作成画面へ</a>
    </div>
</body>
</html>
