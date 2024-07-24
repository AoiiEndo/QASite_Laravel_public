<header class="header fixed-header">
    <div class="logo">
        <img src="{{ asset('images/header.svg') }}" alt="Company Logo">
    </div>
    <nav class="nav-links">
        <a href="{{ route('questions.index') }}" class="{{ Request::is('questions') ? 'current-page-background' : '' }}{{ Request::is('questions/search') ? 'current-page-background' : '' }}{{ Request::is('/') ? 'current-page-background' : '' }}">Home</a>
        @auth
            <a href="{{ route('questions.create') }}" class="{{ Request::is('questions/create') ? 'current-page-background' : '' }}">Questions</a>
            <a href="{{ route('profile') }}" class="{{ Request::is('profile') ? 'current-page-background' : '' }}">Profile</a>
        @endauth
    </nav>
    @auth
        <div class="hamburger-menu" onclick="toggleDropdown()">
            <span>{{ Auth::user()->name ?? 'guest' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
            </svg>
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px"></svg>
        </div>
    @endauth
</header>
