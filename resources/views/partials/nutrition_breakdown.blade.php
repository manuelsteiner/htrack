{{--
    Dashboard-style nutrition breakdown.
    Expects:
      $calories         number|string (or 'NA')
      $caloriesCaption  string  e.g. "per 100 g/ml" (optional, may be '')
      $macros           array of ['label', 'colorKey' (pro|fat|carb), 'value' (string), 'pct' (int)]
      $micros           array of ['label', 'value' (string)]
--}}

<div class="card mb-3">
    <div class="card-body p-4">
        <div class="ht-eyebrow">Calories</div>
        <div class="d-flex align-items-baseline gap-2 mt-2 mb-3">
            <span class="ht-hero-num text-body-emphasis">{{ $calories }}</span>
            <span class="text-body-tertiary fs-5">kcal{{ ($caloriesCaption ?? '') ? ' '.$caloriesCaption : '' }}</span>
        </div>
        <div class="d-flex rounded-pill overflow-hidden" style="height:10px; background:var(--ht-line);" role="img" aria-label="Macro composition">
            @foreach($macros as $m)
                @if($m['pct'] > 0)
                    <div style="width: {{ $m['pct'] }}%; background: var(--ht-{{ $m['colorKey'] }});" title="{{ $m['label'] }} {{ $m['pct'] }}%"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    @foreach($macros as $m)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="ht-dot ht-dot-{{ $m['colorKey'] }}"></span>
                        <span class="fw-semibold text-body-secondary" style="font-size:.8125rem;">{{ $m['label'] }}</span>
                    </div>
                    <div class="ht-macro-num text-body-emphasis">{{ $m['value'] }}</div>
                    <div class="progress mt-3 ht-{{ $m['colorKey'] }}" role="progressbar" aria-label="{{ $m['label'] }}" aria-valuenow="{{ $m['pct'] }}" aria-valuemin="0" aria-valuemax="100" style="height:6px;">
                        <div class="progress-bar" style="width: {{ $m['pct'] }}%;"></div>
                    </div>
                    <div class="text-body-tertiary mt-2" style="font-size:.6875rem;">{{ $m['pct'] }}% of calories</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    @foreach($micros as $s)
        <div class="col-6 col-lg-3">
            <div class="card ht-card-stat h-100">
                <div class="card-body px-3 py-3">
                    <div class="ht-stat-num">{{ $s['value'] }}</div>
                    <div class="text-body-tertiary mt-1" style="font-size:.75rem;">{{ $s['label'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
