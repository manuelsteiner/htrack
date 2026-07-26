@extends('layouts.app')

@section('content')
<div class="container px-3" style="max-width: 1180px;">
    <div class="d-flex justify-content-center" style="padding-top: 48px;">
        <div class="card w-100" style="max-width: 420px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="mb-1" style="font-size:22px; font-weight:800; letter-spacing:-.4px;">{{ __('Reset password') }}</h1>
                <p class="text-body-secondary mb-4">We'll e-mail you a reset link.</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('E-mail address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">{{ __('Send password reset link') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
