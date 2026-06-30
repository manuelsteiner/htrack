<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container" style="max-width: 1180px;">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}" style="letter-spacing:-.3px;">
            <span class="ht-logo">H</span>
            <span>{{ config('app.name', 'HTrack') }}</span>
        </a>

        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto ms-lg-4 gap-1">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('consumptions.*') ? 'active' : '' }}" href="{{ route('consumptions.index') }}">{{ __('Consumption') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('foods.*') ? 'active' : '' }}" href="{{ route('foods.index') }}">{{ __('Food') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('weights.*') ? 'active' : '' }}" href="{{ route('weights.index') }}">{{ __('Weight') }}</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li class="nav-item">
                    <button id="theme-toggle" type="button" class="ht-icon-btn" aria-label="{{ __('Toggle theme') }}">
                        <i class="feather-16" data-feather="moon"></i>
                    </button>
                </li>

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="feather-20 align-text-bottom me-1" data-feather="log-in"></i>{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                            <span class="ht-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}"><i class="feather-20 align-text-bottom me-1" data-feather="activity"></i>{{ __('Dashboard') }}</a>
                            <a class="dropdown-item" href="{{ route('settings.index') }}"><i class="feather-20 align-text-bottom me-1" data-feather="settings"></i>{{ __('Settings') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="feather-20 align-text-bottom me-1" data-feather="log-out"></i>{{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
