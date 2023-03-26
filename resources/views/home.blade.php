@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Your Day so Far</h1>

    <div class="card-group">

        <div class="card bg-secondary text-white">
            <div class="card-body text-center valign-middle">
                <h1>{{ $calories }}</h1>
                <h5 class="m-0">calories</h5>
                <h5 class="m-0">consumed</h5>
            </div>
        </div>

        <div class="card bg-secondary {{ ($calories_left < 0) ? 'text-warning' : 'text-white' }}">
            <div class="card-body text-center valign-middle">
                <h1>{{ $calories_left }}</h1>
                <h5 class="m-0">calories</h5>
                <h5 class="m-0">left</h5>
            </div>
        </div>

        <div class="card bg-secondary text-white">
            <div class="card-body text-center valign-middle">
                <h1>{{ $calories_target }}</h1>
                <h5 class="m-0">calories</h5>
                <h5 class="m-0">targeted</h5>
            </div>
        </div>

    </div>

    <div class="card-deck mt-4">

        <div class="card bg-success text-white">
            <div class="card-body text-center valign-middle">
                <h1>{{ $protein }}</h1>
                <h5 class="m-0">protein</h5>
            </div>
        </div>

        <div class="card bg-info text-white">
            <div class="card-body text-center valign-middle">
                <h1>{{ $fat }}</h1>
                <h5 class="m-0">fat</h5>
            </div>
        </div>

        <div class="card bg-danger text-white">
            <div class="card-body text-center valign-middle">
                <h1>{{ $carbohydrates }}</h1>
                <h5 class="m-0">carbs</h5>
            </div>
        </div>

    </div>

    <div class="mt-3">
        Nutritional values might not be accurate if foods with unknown amounts have been consumed.
    </div>

</div>
@endsection
