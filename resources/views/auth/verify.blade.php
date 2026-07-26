@extends('layouts.app')

@section('content')
<div class="container px-3" style="max-width: 1180px;">
    <div class="d-flex justify-content-center" style="padding-top: 48px;">
        <div class="card w-100" style="max-width: 460px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="mb-3" style="font-size:22px; font-weight:800; letter-spacing:-.4px;">{{ __('Verify your e-mail address') }}</h1>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p class="text-body-secondary mb-0">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <a class="text-decoration-none" href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
