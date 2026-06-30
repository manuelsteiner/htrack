@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <a href="{{ route('consumptions.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-body-secondary mb-3" style="font-size:.8125rem;">
            <i class="feather-16" data-feather="chevron-left"></i>Back to consumptions
        </a>

        <h1 class="ht-page-title mb-1">{{ $consumption->food->name }}</h1>
        <div class="text-body-tertiary mb-4" style="font-size:.8125rem;">{{ $consumption->amount_string }} · {{ $consumption->consumed_at_string }}</div>

        @php
            $p = (float) ($consumption->protein ?? 0);
            $f = (float) ($consumption->fat ?? 0);
            $c = (float) ($consumption->carbohydrates ?? 0);
            $total = $p + $f + $c;
            $pct = fn ($v) => $total > 0 ? round($v / $total * 100) : 0;
        @endphp

        @include('partials.nutrition_breakdown', [
            'calories' => $consumption->calories ?? 'NA',
            'caloriesCaption' => '',
            'macros' => [
                ['label' => 'Protein', 'colorKey' => 'pro',  'value' => $consumption->protein_string,       'pct' => $pct($p)],
                ['label' => 'Fat',     'colorKey' => 'fat',  'value' => $consumption->fat_string,           'pct' => $pct($f)],
                ['label' => 'Carbs',   'colorKey' => 'carb', 'value' => $consumption->carbohydrates_string, 'pct' => $pct($c)],
            ],
            'micros' => [
                ['label' => 'Sugar',         'value' => $consumption->sugar_string],
                ['label' => 'Saturated fat', 'value' => $consumption->saturated_fat_string],
                ['label' => 'Fibre',         'value' => $consumption->fibre_string],
                ['label' => 'Sodium',        'value' => $consumption->sodium_string],
            ],
        ])

        <div class="d-flex gap-2 flex-wrap mt-4">
            <form action="{{ route('consumptions.copyToToday', $consumption) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom me-1" data-feather="copy"></i>Copy to today</button>
            </form>
            <form action="{{ route('consumptions.destroy', $consumption) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger"><i class="feather-20 align-text-bottom me-1" data-feather="trash-2"></i>Delete consumption</button>
            </form>
        </div>
    </div>
@endsection
