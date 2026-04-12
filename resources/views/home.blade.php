@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Your Day so Far</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center valign-middle">
                    <h1 class="text-body-emphasis">{{ $calories }}</h1>
                    <h5 class="m-0 text-body-secondary">calories consumed</h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center valign-middle">
                    <h1 class="{{ ($calories_left < 0) ? 'text-warning' : 'text-success' }}">{{ $calories_left }}</h1>
                    <h5 class="m-0 text-body-secondary">calories left</h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center valign-middle">
                    <h1 class="text-body-emphasis">{{ $calories_target }}</h1>
                    <h5 class="m-0 text-body-secondary">calories targeted</h5>
                </div>
            </div>
        </div>

    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">

        <div class="col">
            <div class="card bg-success text-white h-100">
                <div class="card-body text-center valign-middle">
                    <h1>{{ $protein }}</h1>
                    <h5 class="m-0">protein</h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-info text-white h-100">
                <div class="card-body text-center valign-middle">
                    <h1>{{ $fat }}</h1>
                    <h5 class="m-0">fat</h5>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-danger text-white h-100">
                <div class="card-body text-center valign-middle">
                    <h1>{{ $carbohydrates }}</h1>
                    <h5 class="m-0">carbs</h5>
                </div>
            </div>
        </div>

    </div>

    <div class="row row-cols-2 row-cols-md-4 g-4 mt-0">

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $sugar }}</h3>
                    <small class="text-body-secondary">sugar</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $saturated_fat }}</h3>
                    <small class="text-body-secondary">saturated fat</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $fibre }}</h3>
                    <small class="text-body-secondary">fibre</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 bg-body-secondary h-100">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $sodium }}</h3>
                    <small class="text-body-secondary">sodium</small>
                </div>
            </div>
        </div>

    </div>

    <h1 class="mt-5">Your Last Seven Days</h1>

    <div class="table-responsive mt-3">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-end">Calories</th>
                    <th class="text-end">Protein</th>
                    <th class="text-end">Fat</th>
                    <th class="text-end">Carbs</th>
                    <th class="text-end">Sugar</th>
                    <th class="text-end">Sat. Fat</th>
                    <th class="text-end">Fibre</th>
                    <th class="text-end">Sodium</th>
                </tr>
            </thead>
            <tbody>
                @foreach($days as $day)
                <tr>
                    <td>{{ $day['date'] }}</td>
                    <td class="text-end fw-bold {{ $day['calories'] > $day['calories_target'] ? 'text-warning' : 'text-success' }}">{{ $day['calories'] }}</td>
                    <td class="text-end">{{ $day['protein'] }}g</td>
                    <td class="text-end">{{ $day['fat'] }}g</td>
                    <td class="text-end">{{ $day['carbs'] }}g</td>
                    <td class="text-end">{{ $day['sugar'] }}g</td>
                    <td class="text-end">{{ $day['sat_fat'] }}g</td>
                    <td class="text-end">{{ $day['fibre'] }}g</td>
                    <td class="text-end">{{ $day['sodium'] }}mg</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        Nutritional values might not be accurate if foods with unknown amounts have been consumed.
    </div>

</div>
@endsection
