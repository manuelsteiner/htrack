@extends('layouts.app')

@section('content')
<div class="container px-3 px-md-4" style="max-width: 1180px;">

    <h1 class="ht-page-title mb-4">Settings</h1>

    <form method="POST" action="{{ route('settings.update', $settings->id) }}">
        @csrf
        @method('PUT')

        <h2 class="ht-section-title mb-3">Personal</h2>
        <div class="card mb-5">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="">-</option>
                            <option value="male" {{ old('gender', $settings->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $settings->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date"
                               class="form-control @error('birthday') is-invalid @enderror"
                               id="birthday"
                               name="birthday"
                               value="{{ old('birthday', $settings->birthday?->format('Y-m-d')) }}" />
                        @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label for="height" class="form-label">Height (cm)</label>
                        <input type="number"
                               class="form-control @error('height') is-invalid @enderror"
                               id="height"
                               name="height"
                               value="{{ old('height', $settings->height) }}"
                               min="1" />
                        @error('height')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label for="goal_weight" class="form-label">Goal weight (kg)</label>
                        <input type="number"
                               class="form-control @error('goal_weight') is-invalid @enderror"
                               id="goal_weight"
                               name="goal_weight"
                               value="{{ old('goal_weight', $settings->goal_weight) }}"
                               min="0"
                               step="0.1" />
                        @error('goal_weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6 col-md-3">
                        <label for="activity_factor" class="form-label">Activity factor</label>
                        <input type="number"
                               class="form-control @error('activity_factor') is-invalid @enderror"
                               id="activity_factor"
                               name="activity_factor"
                               value="{{ old('activity_factor', $settings->activity_factor) }}"
                               min="1"
                               max="2.5"
                               step="0.01" />
                        <div class="form-text">1.2 (sedentary) to 1.9 (very active)</div>
                        @error('activity_factor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="timezone" class="form-label">Timezone</label>
                        <select class="form-select @error('timezone') is-invalid @enderror" id="timezone" name="timezone">
                            <option value="">-</option>
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                            @endforeach
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <h2 class="ht-section-title mb-3">Calorie targets</h2>
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-7 g-3">
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div class="col">
                            <label for="calorie_targets_{{ $day }}" class="form-label">{{ ucfirst($day) }}</label>
                            <input type="number"
                                   class="form-control @error('calorie_targets.'.$day) is-invalid @enderror"
                                   id="calorie_targets_{{ $day }}"
                                   name="calorie_targets[{{ $day }}]"
                                   value="{{ old('calorie_targets.'.$day, $settings->calorie_targets[$day] ?? '') }}"
                                   min="0"
                                   required />
                            @error('calorie_targets.'.$day)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom me-1" data-feather="save"></i>Save settings</button>
    </form>

    <hr class="my-5">

    <h2 class="ht-section-title mb-2">API tokens</h2>
    <p class="text-body-secondary" style="font-size:.8125rem;">
        Personal access tokens authenticate API and MCP requests. Treat them like passwords —
        store them somewhere safe and never share them.
    </p>

    @if($plainTextToken)
        <div class="alert alert-success" role="alert">
            <strong>New token created.</strong> Copy it now — it will not be shown again.
            <div class="input-group mt-2">
                <input type="text" readonly class="form-control font-monospace" value="{{ $plainTextToken }}" onclick="this.select()">
                <button class="btn btn-outline-secondary" type="button"
                        onclick="navigator.clipboard.writeText('{{ $plainTextToken }}')">
                    Copy
                </button>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('api-tokens.store') }}" class="mb-0">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="token_name" class="form-label">Token name</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="token_name"
                               name="name"
                               placeholder="e.g. Claude Desktop, MCP Client"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">Create token</button>
                    </div>
                </div>
            </form>

            @if($tokens->isEmpty())
                <p class="text-body-tertiary mt-4 mb-0">No API tokens yet.</p>
            @else
                <div class="table-responsive mt-4">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Created</th>
                                <th scope="col">Last used</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                                <tr>
                                    <td class="fw-medium text-body-emphasis">{{ $token->name }}</td>
                                    <td class="text-body-secondary">{{ $token->created_at?->format('Y-m-d H:i') }}</td>
                                    <td class="text-body-secondary">{{ $token->last_used_at?->diffForHumans() ?? 'Never' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('api-tokens.refresh', $token->id) }}" class="d-inline"
                                              onsubmit="return confirm('Refresh this token? The current token will stop working immediately.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Refresh</button>
                                        </form>
                                        <form method="POST" action="{{ route('api-tokens.destroy', $token->id) }}" class="d-inline"
                                              onsubmit="return confirm('Delete this token?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <hr class="my-5">

    <h2 class="ht-section-title mb-2">Authorized connections</h2>
    <p class="text-body-secondary" style="font-size:.8125rem;">
        OAuth applications (such as Claude Web) that have been granted access to your account.
        Revoking a connection invalidates its tokens immediately.
    </p>

    <div class="card mb-4">
        <div class="card-body p-4">
            @if($connections->isEmpty())
                <p class="text-body-tertiary mb-0">No authorized connections.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Application</th>
                                <th scope="col">Authorized</th>
                                <th scope="col">Expires</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($connections as $connection)
                                <tr>
                                    <td class="fw-medium text-body-emphasis">{{ $connection->client->name }}</td>
                                    <td class="text-body-secondary">{{ $connection->authorized_at?->diffForHumans() }}</td>
                                    <td class="text-body-secondary">{{ $connection->expires_at?->diffForHumans() ?? 'Never' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('oauth-connections.destroy', $connection->client->id) }}" class="d-inline"
                                              onsubmit="return confirm('Revoke access for this application?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Revoke</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
