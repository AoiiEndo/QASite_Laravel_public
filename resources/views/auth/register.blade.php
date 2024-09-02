<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザ登録</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="register-bg">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 20px;">新規登録</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <div class="label-with-line">
                    <label for="name">ユーザ名</label>
                </div>
                <input id="name" type="text" name="name" class="form-control" required autocomplete="name" autofocus>
            </div>

            <div class="form-group">
                <div class="label-with-line">
                    <label for="email">メールアドレス</label>
                </div>
                <input id="email" type="email" name="email" class="form-control" required autocomplete="email">
            </div>

            <div class="form-group">
                <div class="label-with-line">
                    <label for="password">パスワード</label>
                </div>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <div class="label-with-line">
                    <label for="password_confirmation">パスワード（確認）</label>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn" style="background-color: #862ccb">新規登録</button>
        </form>
        <a href="{{ route('login') }}" class="btn" style="background-color: #862ccb">ログイン画面へ</a>
        <div class="text-center mt-4" style="display: flex; justify-content: center; gap: 20px;">
            <a href="{{ route('terms') }}" style="color: #fff;">利用規約</a>
            <a href="{{ route('privacyPolicy') }}" style="color: #fff;">プライバシーポリシー</a>
        </div>
    </div>
</body>
</html>
