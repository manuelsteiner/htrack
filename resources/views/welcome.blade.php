@extends('layouts.app')

@section('content')
<div class="container-fluid px-3">
    <div class="d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 72vh;">
        <span class="ht-logo mb-4" style="width:56px; height:56px; border-radius:16px; font-size:30px;">H</span>

        <h1 class="mb-2" style="font-size:40px; font-weight:800; letter-spacing:-1px;">{{ config('app.name', 'HTrack') }}</h1>
        <p class="text-body-secondary mb-4" style="max-width:460px;">
            Track your food, calories and macros — one clean daily view of your day so far.
        </p>

        <div class="d-flex gap-2">
            @auth
                <a href="{{ route('home') }}" class="btn btn-primary"><i class="feather-20 align-text-bottom me-1" data-feather="activity"></i>Go to dashboard</a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">Sign in</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
