<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Declare native support for both schemes so the browser (and extensions
         like DarkReader) know the page adapts and shouldn't force its own dark. -->
    <meta name="color-scheme" content="light dark">

    <!-- Resolve the persisted theme preference before paint to avoid a flash.
         Preference is one of system|light|dark; "system" follows the OS. -->
    <script>
        (function () {
            var pref = localStorage.getItem('theme') || 'system';
            var dark = pref === 'dark' || (pref === 'system' &&
                window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
        })();
    </script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div id="app">
        @include('partials.notifications')
        @include('partials.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
