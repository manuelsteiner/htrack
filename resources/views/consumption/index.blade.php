@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-none d-md-block">
            @include('consumption.create_form', ['foods' => $foods])
        </div>

        <div class="d-md-none">
            <a class="btn btn-primary" href="{{ route('consumptions.create') }}" role="button"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add a Consumption</a>
        </div>

        <h1 class="mt-4">Copy Date to Today</h1>
        <form action="{{ route('consumptions.copyDate') }}" method="post" class="d-flex align-items-center gap-2 mb-4">
            @csrf
            <input type="date" class="form-control w-auto" id="date" name="date" max="{{ now()->subDay()->toDateString() }}" required>
            <button class="btn btn-primary text-nowrap" type="submit"><i class="feather-20 align-text-bottom me-1" data-feather="copy"></i>Copy</button>
        </form>

        <h1 class="mt-4">Consumptions</h1>

        <div class="row">

            <div class="col-md-9">

                <form action="{{ route('consumptions.index') }}" method="get">

                    <div class="input-group mb-3">
                        @if(request()->sort)
                            <input type="hidden" id="sort" name="sort" value="{{ request()->sort }}">
                        @endif

                        <input type="text" class="form-control" id="search" name="search" placeholder="Search Consumptions (food name, date)">
                        <button class="btn btn-outline-secondary" type="submit"><i class="feather-20 align-text-bottom me-1" data-feather="search"></i>Search Consumptions</button>
                    </div>
                </form>

            </div>

            <div class="col-md-auto mt-1 mt-md-0 ms-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" id="sortOrderDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="feather-20 align-text-bottom me-1" data-feather="arrow-up"></i>
                        Sort By
                    </button>
                    <div class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuButton">
                        <form action="{{ route('consumptions.index') }}" method="get">
                            @if(request()->search)
                                <input type="hidden" id="search" name="search" value="{{ request()->search }}">
                            @endif

                            <button type="submit" name="sort" value="date-asc" class="dropdown-item"><i class="feather-20 align-text-bottom me-1" data-feather="arrow-up"></i>Date</button>
                            <button type="submit" name="sort" value="date-desc" class="dropdown-item"><i class="feather-20 align-text-bottom me-1" data-feather="arrow-down"></i>Date</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @forelse ($consumptions as $consumption)
            @component('consumption.overview_card', [ 'consumption' => $consumption ])
            @endcomponent
        @empty
            <p>There is currently no consumption in the database or matching the search query.</p>
        @endforelse

        <div class="mt-2">
            {{ $consumptions->links() }}
        </div>

        <p class="mt-3">
            Nutritional information denotes
            <span class="badge text-bg-secondary">Calories</span>,
            <span class="badge text-bg-success">Protein</span>,
            <span class="badge text-bg-info">Fat</span>,
            <span class="badge text-bg-danger">Carbohydrates</span>
            of the consumed food amount.
        </p>

    </div>
    @endsection


