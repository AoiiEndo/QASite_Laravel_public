@extends('layouts.app')

@section('content')
<div class="container">
    <h1>プライバシーポリシー</h1>
    <p>私たちは、ユーザーのプライバシーを尊重し、適切に保護することをお約束します。このプライバシーポリシーは、当サービスにおけるユーザー情報の収集、使用、および保護に関する方針を説明しています。</p>

    <h2>1. 収集する情報</h2>
    <ol>
        <li>ユーザーのメールアドレス（ログイン認証やお問い合わせに使用します）</li>
        <li>パスワード（ハッシュ化して保存します）</li>
        <li>お問い合わせ内容（ユーザーからのフィードバックを含む）</li>
    </ol>

    <h2>2. 情報の使用方法</h2>
    <ol>
        <li>ユーザーのメールアドレスは、アカウントの管理、通知、およびお問い合わせへの対応に使用します。</li>
        <li>パスワードは、ログインのために必要な認証を行う際に使用します。</li>
        <li>お問い合わせ内容は、ユーザーからのフィードバックの確認や対応のために使用します。</li>
    </ol>

    <h2>3. 情報の保護</h2>
    <ol>
        <li>パスワードはハッシュ化して保存し、セキュリティを保ちます。</li>
        <li>ユーザーの個人情報を保護するために、インジェクションやクロスサイトスクリプティング（XSS）対策を行っています。</li>
        <li>提供されたメールアドレスは、安全に管理され、外部への不正な開示を防ぎます。</li>
    </ol>

    <h2>4. クッキーの使用</h2>
    <p>当サービスでは、クッキーを使用していません。</p>

    <h2>5. 情報の開示とリクエスト</h2>
    <p>ユーザーが自分の情報を開示したり、削除をリクエストする場合は、以下のリンクからお問い合わせフォームをご利用ください。</p>
    <p><a href="{{ route('contact') }}" style="color: #fff;">お問い合わせフォーム</a></p>

    <h2>6. 情報の第三者提供</h2>
    <p>当サービスは、法令に基づく場合を除き、ユーザーの個人情報を第三者に提供することはありません。</p>

    <h2>7. データの保存期間</h2>
    <p>お問い合わせ内容に関連するデータは、対応が完了した後、一定期間保存され、その後安全に削除されます。</p>

    <h2>8. ポリシーの変更</h2>
    <p>本ポリシーは必要に応じて変更されることがあります。変更があった場合は、当サービス上に掲示し、通知とさせていただきます。</p>

    <h2>9. 連絡先</h2>
    <p>プライバシーポリシーに関する質問やリクエストがある場合は、以下のリンクからお問い合わせフォームをご利用ください。</p>
    <p><a href="{{ route('contact') }}" style="color: #fff;">お問い合わせフォーム</a></p>
</div>
@endsection
