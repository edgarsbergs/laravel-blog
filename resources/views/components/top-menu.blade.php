<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" id="top-menu">
    <a class="navbar-brand" href="{{ route('home') }}">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @if (Auth::guest())
                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/register') }}" class="nav-link">Register</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ url('/admin') }}" class="nav-link">Admin</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
