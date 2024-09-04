<header class="header fixed-header">
    <div class="logo">
        <img src="{{ asset('images/header.svg') }}" alt="Company Logo">
    </div>
    <nav class="nav-links">
        <a href="{{ route('questions.index') }}" class="{{ Request::is('/') || Request::is('questions/search') || Request::is('/') ? 'current-page-background' : '' }}">Home</a>
        @auth
            <a href="{{ route('questions.create') }}" class="{{ Request::is('questions/create') ? 'current-page-background' : '' }}">Questions</a>
            <a href="{{ route('exercises.index') }}" class="{{ Request::is('exercises') ? 'current-page-background' : '' }}">Exercises</a>
            <a href="{{ route('profile') }}" class="{{ Request::is('profile') ? 'current-page-background' : '' }}">Profile</a>
        @endauth
    </nav>
    @auth
        <div class="hamburger-menu" id="hamburger-menu">
            <span>{{ Auth::user()->name ?? 'guest' }}</span>
            <div class="dropdown-menu" style="background-color: #1a202c;">
                <ul class="dropdown-menu-list">
                    <li><a class="dropdown-item" href="{{ route('terms') }}">利用規約</a></li>
                    <li><a class="dropdown-item" href="{{ route('privacyPolicy') }}">プライバシーポリシー</a></li>
                    <li><a class="dropdown-item" href="{{ route('contact') }}">お問い合わせ</a></li>
                    @if(Auth::check() && Auth::user()->id === 1)
                        <a href="{{ route('inquiries') }}" class="dropdown-item">お問い合わせ管理</a>
                    @endif
                    <li>
                        <a class="dropdown-item" href="#" id="logout-link">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div class="hamburger-menu">
            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-button">ログイン</a>
                <a href="{{ route('register') }}" class="auth-button">新規登録</a>
            </div>
            <span>{{ 'Guest' }}</span>
        </div>
    @endauth
</header>
