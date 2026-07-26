<div class="card ht-list-row">
    <div class="card-body py-3 px-4 position-relative">
        <a class="stretched-link outline-none" href="{{ route('consumptions.show', $consumption) }}" aria-label="{{ $consumption->food->name }}"></a>

        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div>
                <div class="fw-semibold" style="font-size:15px;">{{ $consumption->food->name }}</div>
                <div class="text-body-tertiary mt-1" style="font-size:.8125rem;">{{ $consumption->amount_string }} · {{ $consumption->consumed_at_string }}</div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <span class="ht-chip ht-chip-cal">{{ $consumption->calories }}</span>
                    <span class="ht-chip ht-chip-pro">{{ $consumption->protein_string }}</span>
                    <span class="ht-chip ht-chip-fat">{{ $consumption->fat_string }}</span>
                    <span class="ht-chip ht-chip-carb">{{ $consumption->carbohydrates_string }}</span>
                </div>

                <div class="dropdown ht-kebab-wrap d-none d-md-block">
                    <button class="ht-kebab" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Consumption actions">
                        <i class="feather-20" data-feather="more-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <form action="{{ route('consumptions.copyToToday', $consumption) }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="feather-16 align-text-bottom me-2" data-feather="copy"></i>Copy to today</button>
                        </form>
                        <form action="{{ route('consumptions.destroy', $consumption) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="dropdown-item dropdown-item-delete"><i class="feather-16 align-text-bottom me-2" data-feather="trash-2"></i>Delete consumption</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
