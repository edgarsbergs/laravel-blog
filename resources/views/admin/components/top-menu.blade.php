<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" id="top-menu">
    <a class="navbar-brand" href="{{ route('admin') }}">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('admin.posts') }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('admin/posts') }}">{{ __('admin.posts') }}</a>
                    <a class="dropdown-item" href="{{ route('newPost') }}">{{ __('admin.add_new') }}</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link">{{ __('buttons.logout') }}</a>
            </li>
        </ul>
    </div>
</nav>
