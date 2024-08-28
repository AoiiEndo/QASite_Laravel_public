<header class="header fixed-header">
    <div class="logo">
        <img src="{{ asset('images/header.svg') }}" alt="Company Logo">
    </div>
    <nav class="nav-links">
        <a href="{{ route('questions.index') }}" class="{{ Request::is('questions') || Request::is('questions/search') || Request::is('/') ? 'current-page-background' : '' }}">Home</a>
        @auth
            <a href="{{ route('questions.create') }}" class="{{ Request::is('questions/create') ? 'current-page-background' : '' }}">Questions</a>
            <a href="{{ route('exercises.index') }}" class="{{ Request::is('exercises') ? 'current-page-background' : '' }}">Exercises</a>
            <a href="{{ route('profile') }}" class="{{ Request::is('profile') ? 'current-page-background' : '' }}">Profile</a>
        @endauth
    </nav>
    @auth
        <div class="hamburger-menu" onclick="toggleDropdown()">
            <span>{{ Auth::user()->name ?? 'guest' }}</span>
            <div class="menu-toggle" id="menuToggle">
                <!-- ハンバーガーアイコン -->
                <svg class="hamburger-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                </svg>
                <!-- バッテンアイコン -->
                <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
                    <path d="M18.364 5.636l-1.028-1.028L12 8.934 6.664 3.6 5.636 4.628 11.971 11l-6.335 6.335 1.028 1.028 6.335-6.335 6.335 6.335 1.028-1.028-6.335-6.335z"/>
                </svg>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    @else
        <div class="hamburger-menu">
            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-button">Login</a>
                <a href="{{ route('register') }}" class="auth-button">Register</a>
            </div>
            <span>{{ 'Guest' }}</span>
        </div>
    @endauth
</header>
