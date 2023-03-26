@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-none d-md-block">
            @include('weight.create_form')
        </div>

        <div class="d-md-none">
            <a class="btn btn-primary" href="{{ route('weights.create') }}" role="button"><i class="feather-20 align-text-bottom mr-1" data-feather="plus"></i>Add a Weight</a>
        </div>

        <h1 class="mt-4">Weights</h1>

        @forelse ($weights as $weight)
            @component('weight.overview_card', [ 'weight' => $weight ])
            @endcomponent
        @empty
            <p>There is currently no weight in the database.</p>
        @endforelse

        <div class="mt-2">
            {{ $weights->links() }}
        </div>

        <p class="mt-3">
            The
            <span class="badge badge-secondary">Difference</span>
            denotes the weight change to the previously recorded weight.
        </p>

    </div>
@endsection