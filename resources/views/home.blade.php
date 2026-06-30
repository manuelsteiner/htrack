@extends('layouts.app')

@section('content')
<div class="container px-3 px-md-4" style="max-width: 1180px;">

    <div class="mb-4">
        <h1 class="ht-page-title mb-1">Your day so far</h1>
        <div class="text-body-tertiary" style="font-size:.8125rem;">{{ now()->format('l, j F Y') }}</div>
    </div>

    {{-- Calorie hero --}}
    <div class="card mb-3">
        <div class="card-body p-4">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <div class="ht-eyebrow">Calories</div>
                    <div class="d-flex align-items-baseline gap-2 mt-2">
                        <span class="ht-hero-num text-body-emphasis">{{ number_format($calories) }}</span>
                        <span class="text-body-tertiary fs-5">/ {{ number_format($calories_target) }} kcal</span>
                    </div>
                </div>
                @if ($calories_left >= 0)
                    <div class="ht-left-pill">
                        <span class="fw-bold fs-5">{{ number_format($calories_left) }}</span>
                        <span class="fw-semibold" style="font-size:.8125rem;">kcal left</span>
                    </div>
                @else
                    <div class="ht-left-pill ht-over-pill">
                        <span class="fw-bold fs-5">{{ number_format(abs($calories_left)) }}</span>
                        <span class="fw-semibold" style="font-size:.8125rem;">kcal over</span>
                    </div>
                @endif
            </div>
            <div class="progress" role="progressbar" aria-label="Calories" aria-valuenow="{{ $calorie_percent }}" aria-valuemin="0" aria-valuemax="100" style="height:10px;">
                <div class="progress-bar" style="width: {{ $calorie_percent }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Macros --}}
    <div class="row g-3 mb-3">
        @foreach ([
            ['label' => 'Protein', 'dot' => 'ht-dot-pro', 'bar' => 'ht-pro', 'value' => $protein_g, 'pct' => $protein_pct],
            ['label' => 'Fat', 'dot' => 'ht-dot-fat', 'bar' => 'ht-fat', 'value' => $fat_g, 'pct' => $fat_pct],
            ['label' => 'Carbs', 'dot' => 'ht-dot-carb', 'bar' => 'ht-carb', 'value' => $carbs_g, 'pct' => $carbs_pct],
        ] as $macro)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="ht-dot {{ $macro['dot'] }}"></span>
                            <span class="fw-semibold text-body-secondary" style="font-size:.8125rem;">{{ $macro['label'] }}</span>
                        </div>
                        <div class="ht-macro-num text-body-emphasis">{{ $macro['value'] }}<span class="fs-5 fw-semibold text-body-tertiary">g</span></div>
                        <div class="progress mt-3 {{ $macro['bar'] }}" role="progressbar" aria-label="{{ $macro['label'] }}" aria-valuenow="{{ $macro['pct'] }}" aria-valuemin="0" aria-valuemax="100" style="height:6px;">
                            <div class="progress-bar" style="width: {{ $macro['pct'] }}%;"></div>
                        </div>
                        <div class="text-body-tertiary mt-2" style="font-size:.6875rem;">{{ $macro['pct'] }}% of macros</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Micro stats --}}
    <div class="row g-3 mb-5">
        @foreach ([
            ['label' => 'Sugar', 'value' => $sugar],
            ['label' => 'Saturated fat', 'value' => $saturated_fat],
            ['label' => 'Fibre', 'value' => $fibre],
            ['label' => 'Sodium', 'value' => $sodium],
        ] as $stat)
            <div class="col-6 col-lg-3">
                <div class="card ht-card-stat h-100">
                    <div class="card-body px-3 py-3">
                        <div class="ht-stat-num">{{ $stat['value'] }}</div>
                        <div class="text-body-tertiary mt-1" style="font-size:.75rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="ht-section-title mb-3">Your last seven days</h2>
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="min-width:760px;">
                <thead>
                    <tr>
                        <th class="ps-4">Date</th>
                        <th class="text-end">Calories</th>
                        <th class="text-end">Protein</th>
                        <th class="text-end">Fat</th>
                        <th class="text-end">Carbs</th>
                        <th class="text-end">Sugar</th>
                        <th class="text-end">Sat. fat</th>
                        <th class="text-end">Fibre</th>
                        <th class="text-end pe-4">Sodium</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($days as $day)
                        <tr>
                            <td class="ps-4 fw-medium text-body-emphasis">{{ $day['date'] }}</td>
                            <td class="text-end"><span class="ht-cal-pill {{ $day['calories'] > $day['calories_target'] ? 'ht-over-pill' : '' }}">{{ number_format($day['calories']) }}</span></td>
                            <td class="text-end text-body-secondary">{{ $day['protein'] }}g</td>
                            <td class="text-end text-body-secondary">{{ $day['fat'] }}g</td>
                            <td class="text-end text-body-secondary">{{ $day['carbs'] }}g</td>
                            <td class="text-end text-body-secondary">{{ $day['sugar'] }}g</td>
                            <td class="text-end text-body-secondary">{{ $day['sat_fat'] }}g</td>
                            <td class="text-end text-body-secondary">{{ $day['fibre'] }}g</td>
                            <td class="text-end text-body-secondary pe-4">{{ $day['sodium'] }}mg</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-body-tertiary mt-3" style="font-size:.75rem;">Nutritional values might not be accurate if foods with unknown amounts have been consumed.</div>

</div>
@endsection
