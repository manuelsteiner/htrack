@extends('layouts.app')

@section('content')
<div class="container-fluid px-3">
    <div class="d-flex justify-content-center" style="padding-top: 48px;">
        <div class="card w-100" style="max-width: 480px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="mb-1" style="font-size:22px; font-weight:800; letter-spacing:-.4px;">{{ __('Authorization request') }}</h1>
                <p class="text-body-secondary mb-4">
                    <strong class="text-body-emphasis">{{ $client->name }}</strong>
                    {{ __('is requesting permission to access your account.') }}
                </p>

                @if (count($scopes) > 0)
                    <div class="ht-eyebrow mb-2">{{ __('This application will be able to') }}</div>
                    <ul class="list-unstyled mb-4">
                        @foreach ($scopes as $scope)
                            <li class="d-flex align-items-start gap-2 mb-2">
                                <i class="feather-16" data-feather="check" style="color:var(--ht-pro); flex:none; margin-top:2px;"></i>
                                <span>{{ $scope->description }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('passport.authorizations.approve') }}" class="flex-fill">
                        @csrf
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Authorize') }}</button>
                    </form>

                    <form method="POST" action="{{ route('passport.authorizations.deny') }}" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <button type="submit" class="btn btn-outline-secondary w-100">{{ __('Cancel') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
