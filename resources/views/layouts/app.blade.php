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

    <!-- theme-color tints the browser/OS chrome (Safari toolbar, task
         switcher card) to match the page background per scheme. -->
    <meta name="theme-color" content="#f5f6f8" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f141b" media="(prefers-color-scheme: dark)">

    <!-- iOS "Add to Home Screen": opens without Safari's chrome and picks
         up apple-touch-icon.png + this title for the home-screen icon. No
         manifest.json/service worker — this app has no offline behaviour,
         and Android's install prompt is a separate, more involved feature
         (WebAPK) not needed here. -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'Laravel') }}">
    <meta name="application-name" content="{{ config('app.name', 'Laravel') }}">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">

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
