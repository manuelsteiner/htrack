<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consumptions.index') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="droplet"></i>{{ __('Consumption') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('foods.index') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="coffee"></i>{{ __('Food') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('weights.index') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="sliders"></i>{{ __('Weight') }}</a>
                    </li>
                @endauth

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="log-in"></i>{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="feather-20 align-text-bottom mr-1" data-feather="user"></i>{{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="activity"></i>{{ __('Dashboard') }}</a>
                            <a class="dropdown-item" href="{{ route('settings.index') }}"><i class="feather-20 align-text-bottom mr-1" data-feather="settings"></i>{{ __('Settings') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="feather-20 align-text-bottom mr-1" data-feather="log-out"></i>{{ __('Logout') }}
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