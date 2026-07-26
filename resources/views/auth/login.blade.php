@extends('layouts.app')

@section('content')
<div class="container px-3" style="max-width: 1180px;">
    <div class="d-flex justify-content-center" style="padding-top: 48px;">
        <div class="card w-100" style="max-width: 420px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="mb-1" style="font-size:22px; font-weight:800; letter-spacing:-.4px;">Welcome back</h1>
                <p class="text-body-secondary mb-4">Sign in to keep tracking your day.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('E-mail address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">{{ __('Sign in') }}</button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="text-decoration-none text-body-secondary" style="font-size:.8125rem;" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
