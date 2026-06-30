@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <h1 class="ht-page-title mb-4">Consumptions</h1>

        {{-- Add a consumption: inline card on desktop, dedicated page on mobile --}}
        <div class="d-none d-md-block mb-5">
            <h2 class="ht-section-title mb-3">Add a consumption</h2>
            <div class="card">
                <div class="card-body p-4">
                    @include('consumption.create_form', ['foods' => $foods])
                </div>
            </div>
        </div>

        <div class="d-md-none mb-4">
            <a class="btn btn-primary w-100" href="{{ route('consumptions.create') }}" role="button"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add a consumption</a>
        </div>

        {{-- Copy a date to today --}}
        <h2 class="ht-section-title mb-3">Copy a date to today</h2>
        <div class="card mb-5">
            <div class="card-body p-4">
                <form action="{{ route('consumptions.copyDate') }}" method="post" class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3">
                    @csrf
                    <input type="date" class="form-control w-auto" id="date" name="date" max="{{ now()->subDay()->toDateString() }}" required>
                    <button class="btn btn-primary text-nowrap" type="submit"><i class="feather-20 align-text-bottom me-1" data-feather="copy"></i>Copy to today</button>
                    <span class="text-body-tertiary" style="font-size:.8125rem;">Duplicates every consumption from the chosen day onto today.</span>
                </form>
            </div>
        </div>

        {{-- Search + sort --}}
        <h2 class="ht-section-title mb-3">Your consumptions</h2>
        <div class="d-flex flex-column flex-md-row gap-2 mb-4">
            <form action="{{ route('consumptions.index') }}" method="get" class="ht-search">
                @if(request()->sort)
                    <input type="hidden" name="sort" value="{{ request()->sort }}">
                @endif
                <i class="ht-search-icon feather-16" data-feather="search"></i>
                <input type="text" class="form-control ps-5" name="search" value="{{ request()->search }}" placeholder="Search consumptions (food name, date)">
            </form>

            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-nowrap" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="feather-16 align-text-bottom me-1" data-feather="arrow-up"></i>Sort by
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <form action="{{ route('consumptions.index') }}" method="get">
                        @if(request()->search)
                            <input type="hidden" name="search" value="{{ request()->search }}">
                        @endif
                        <button type="submit" name="sort" value="date-desc" class="dropdown-item"><i class="feather-16 align-text-bottom me-2" data-feather="arrow-down"></i>Newest first</button>
                        <button type="submit" name="sort" value="date-asc" class="dropdown-item"><i class="feather-16 align-text-bottom me-2" data-feather="arrow-up"></i>Oldest first</button>
                    </form>
                </div>
            </div>
        </div>

        @forelse ($consumptions as $consumption)
            @component('consumption.overview_card', [ 'consumption' => $consumption ])
            @endcomponent
        @empty
            <div class="card">
                <div class="card-body p-4 text-body-secondary text-center">
                    There is currently no consumption in the database or matching the search query.
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $consumptions->links() }}
        </div>

        <p class="mt-3 text-body-tertiary" style="font-size:.8125rem;">
            Chips show
            <span class="fw-semibold" style="color:var(--ht-cal);">calories</span>,
            <span class="fw-semibold" style="color:var(--ht-pro);">protein</span>,
            <span class="fw-semibold" style="color:var(--ht-fat);">fat</span> and
            <span class="fw-semibold" style="color:var(--ht-carb);">carbohydrates</span>
            of the consumed amount.
        </p>
    </div>
@endsection
