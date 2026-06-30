@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <h1 class="ht-page-title mb-4">Food</h1>

        {{-- Add a food item: inline card on desktop, dedicated page on mobile --}}
        <div class="d-none d-md-block mb-5">
            <h2 class="ht-section-title mb-3">Add a food item</h2>
            <div class="card">
                <div class="card-body p-4">
                    @include('food.create_form')
                </div>
            </div>
        </div>

        <div class="d-md-none mb-4">
            <a class="btn btn-primary w-100" href="{{ route('foods.create') }}" role="button"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add a food item</a>
        </div>

        {{-- Search + sort --}}
        <h2 class="ht-section-title mb-3">Your food</h2>
        <div class="d-flex flex-column flex-md-row gap-2 mb-4">
            <form action="{{ route('foods.index') }}" method="get" class="ht-search">
                @if(request()->sort)
                    <input type="hidden" name="sort" value="{{ request()->sort }}">
                @endif
                <i class="ht-search-icon feather-16" data-feather="search"></i>
                <input type="text" class="form-control ps-5" name="search" value="{{ request()->search }}" placeholder="Search food by name">
            </form>

            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-nowrap" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="feather-16 align-text-bottom me-1" data-feather="arrow-up"></i>Sort by
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <form action="{{ route('foods.index') }}" method="get">
                        @if(request()->search)
                            <input type="hidden" name="search" value="{{ request()->search }}">
                        @endif
                        <button type="submit" name="sort" value="name-asc" class="dropdown-item"><i class="feather-16 align-text-bottom me-2" data-feather="arrow-up"></i>Name (A–Z)</button>
                        <button type="submit" name="sort" value="name-desc" class="dropdown-item"><i class="feather-16 align-text-bottom me-2" data-feather="arrow-down"></i>Name (Z–A)</button>
                    </form>
                </div>
            </div>
        </div>

        @forelse ($foods as $food)
            @component('food.overview_card', [ 'food' => $food ])
            @endcomponent
        @empty
            <div class="card">
                <div class="card-body p-4 text-body-secondary text-center">
                    There is currently no food in the database or matching the search query.
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $foods->links() }}
        </div>

        <p class="mt-3 text-body-tertiary" style="font-size:.8125rem;">
            Chips show
            <span class="fw-semibold" style="color:var(--ht-cal);">calories</span>,
            <span class="fw-semibold" style="color:var(--ht-pro);">protein</span>,
            <span class="fw-semibold" style="color:var(--ht-fat);">fat</span> and
            <span class="fw-semibold" style="color:var(--ht-carb);">carbohydrates</span>
            per 100 g/ml of food.
        </p>
    </div>
@endsection
