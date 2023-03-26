@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-none d-md-block">
            @include('food.create_form')
        </div>

        <div class="d-md-none">
            <a class="btn btn-primary" href="{{ route('foods.create') }}" role="button"><i class="feather-20 align-text-bottom mr-1" data-feather="plus"></i>Add a Food Item</a>
        </div>

        <h1 class="mt-4">Food</h1>

        <div class="row mb-3">

            <div class="col-md-9">

                <form action="{{ route('foods.index') }}" method="get">
                    @if(request()->sort)
                        <input type="hidden" id="sort" name="sort" value="{{ request()->sort }}">
                    @endif

                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search Food (name)">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="feather-20 align-text-bottom mr-1" data-feather="search"></i>Search Food</button>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-md-auto mt-1 mt-md-0 ml-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-block dropdown-toggle" type="button" id="sortOrderDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather-20 align-text-bottom mr-1" data-feather="arrow-up"></i>
                        Sort By
                    </button>
                    <div class="dropdown-menu dropdown-menu-right w-100" aria-labelledby="dropdownMenuButton">
                        <form action="{{ route('foods.index') }}" method="get">
                            @if(request()->search)
                                <input type="hidden" id="search" name="search" value="{{ request()->search }}">
                            @endif

                            <button type="submit" name="sort" value="name-asc" class="dropdown-item btn-block"><i class="feather-20 align-text-bottom mr-1" data-feather="arrow-up"></i>Name</button>
                            <button type="submit" name="sort" value="name-desc" class="dropdown-item btn-block"><i class="feather-20 align-text-bottom mr-1" data-feather="arrow-down"></i>Name</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @forelse ($foods as $food)
            @component('food.overview_card', [ 'food' => $food ])
            @endcomponent
        @empty
            <p>There is currently no food in the database or matching the search query.</p>
        @endforelse

        <div class="mt-2">
            {{ $foods->links() }}
        </div>

        <p class="mt-3">
            Nutritional information denotes
            <span class="badge badge-secondary">Calories</span>,
            <span class="badge badge-success">Protein</span>,
            <span class="badge badge-info">Fat</span>,
            <span class="badge badge-danger">Carbohydrates</span>
            per 100g/ml of food.
        </p>
    </div>
@endsection