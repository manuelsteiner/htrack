@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <h1 class="ht-page-title mb-4">Weight</h1>

        {{-- Add a weight: inline card on desktop, dedicated page on mobile --}}
        <div class="d-none d-md-block mb-5">
            <h2 class="ht-section-title mb-3">Add a weight</h2>
            <div class="card">
                <div class="card-body p-4">
                    @include('weight.create_form')
                </div>
            </div>
        </div>

        <div class="d-md-none mb-4">
            <a class="btn btn-primary w-100" href="{{ route('weights.create') }}" role="button"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add a weight</a>
        </div>

        <h2 class="ht-section-title mb-3">Your weights</h2>

        @forelse ($weights as $weight)
            @component('weight.overview_card', [ 'weight' => $weight ])
            @endcomponent
        @empty
            <div class="card">
                <div class="card-body p-4 text-body-secondary text-center">
                    There is currently no weight in the database.
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $weights->links() }}
        </div>

        <p class="mt-3 text-body-tertiary" style="font-size:.8125rem;">
            The chip shows the weight change relative to the previously recorded weight.
        </p>
    </div>
@endsection
