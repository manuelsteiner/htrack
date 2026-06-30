@extends('layouts.app')

@section('content')
<div class="container px-3" style="max-width: 1180px;">
    <div class="d-flex justify-content-center" style="padding-top: 48px;">
        <div class="card w-100" style="max-width: 460px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="mb-4" style="font-size:22px; font-weight:800; letter-spacing:-.4px;">{{ __('Reset password') }}</h1>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('E-mail address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirm password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">{{ __('Reset password') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
