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
            <div class="dropdown-menu" style="background-color: #1a202c;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
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
