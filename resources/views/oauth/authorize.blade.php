@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Authorization Request') }}</div>

                <div class="card-body">
                    <p>
                        <strong>{{ $client->name }}</strong>
                        is requesting permission to access your account.
                    </p>

                    @if (count($scopes) > 0)
                        <p class="mb-2">{{ __('This application will be able to:') }}</p>
                        <ul>
                            @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="d-flex gap-2 mt-4">
                        <form method="POST" action="{{ route('passport.authorizations.approve') }}">
                            @csrf
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button type="submit" class="btn btn-primary">{{ __('Authorize') }}</button>
                        </form>

                        <form method="POST" action="{{ route('passport.authorizations.deny') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button type="submit" class="btn btn-outline-secondary">{{ __('Cancel') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
