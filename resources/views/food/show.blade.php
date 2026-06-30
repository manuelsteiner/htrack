@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <a href="{{ route('foods.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-body-secondary mb-3" style="font-size:.8125rem;">
            <i class="feather-16" data-feather="chevron-left"></i>Back to food
        </a>

        <h1 class="ht-page-title mb-1">{{ $food->name }}</h1>
        <div class="text-body-tertiary mb-4" style="font-size:.8125rem;">
            Per 100 g/ml
            @if($food->serving_size)
                · serving size {{ $food->serving_size }} g/ml
            @endif
        </div>

        @php
            $p = (float) ($food->protein ?? 0);
            $f = (float) ($food->fat ?? 0);
            $c = (float) ($food->carbohydrates ?? 0);
            $total = $p + $f + $c;
            $pct = fn ($v) => $total > 0 ? round($v / $total * 100) : 0;
        @endphp

        @include('partials.nutrition_breakdown', [
            'calories' => $food->calories ?? 'NA',
            'caloriesCaption' => 'per 100 g/ml',
            'macros' => [
                ['label' => 'Protein', 'colorKey' => 'pro',  'value' => $food->protein_string,       'pct' => $pct($p)],
                ['label' => 'Fat',     'colorKey' => 'fat',  'value' => $food->fat_string,           'pct' => $pct($f)],
                ['label' => 'Carbs',   'colorKey' => 'carb', 'value' => $food->carbohydrates_string, 'pct' => $pct($c)],
            ],
            'micros' => [
                ['label' => 'Sugar',         'value' => $food->sugar_string],
                ['label' => 'Saturated fat', 'value' => $food->saturated_fat_string],
                ['label' => 'Fibre',         'value' => $food->fibre_string],
                ['label' => 'Sodium',        'value' => $food->sodium_string],
            ],
        ])

        <div class="d-flex gap-2 flex-wrap mt-4">
            <a class="btn btn-primary" href="{{ route('foods.edit', $food) }}" role="button"><i class="feather-20 align-text-bottom me-1" data-feather="edit"></i>Edit food item</a>
            <form action="{{ route('foods.destroy', $food) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger" @if($food->consumptions_count) disabled @endif><i class="feather-20 align-text-bottom me-1" data-feather="trash-2"></i>Delete food item</button>
            </form>
        </div>
    </div>
@endsection
