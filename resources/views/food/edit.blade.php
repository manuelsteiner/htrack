@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <a href="{{ route('foods.show', $food) }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-body-secondary mb-3" style="font-size:.8125rem;">
            <i class="feather-16" data-feather="chevron-left"></i>Back to {{ $food->name }}
        </a>

        <h1 class="ht-page-title mb-1">Edit food item</h1>
        <div class="text-body-tertiary mb-4" style="font-size:.8125rem;">
            @if($food->consumptions_count)
                Used in {{ $food->consumptions_count }} {{ Str::plural('consumption', $food->consumptions_count) }}. Changes to the nutritional values apply to all of them.
            @else
                Not used in any consumption yet.
            @endif
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form class="needs-validation" action="{{ route('foods.update', $food) }}" method="post" novalidate>
                    @method('PUT')
                    @include('food.fields', ['food' => $food])

                    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom me-1" data-feather="check"></i>Save changes</button>
                        <a class="btn btn-outline-secondary" href="{{ route('foods.show', $food) }}" role="button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
