<div class="card ht-list-row">
    <div class="card-body py-3 px-4 position-relative">
        <a class="stretched-link outline-none" href="{{ route('weights.show', $weight) }}" aria-label="{{ $weight->weight_string }}"></a>

        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div>
                <div class="fw-semibold" style="font-size:15px;">{{ $weight->weight_string }}</div>
                <div class="text-body-tertiary mt-1" style="font-size:.8125rem;">{{ $weight->date_string }}</div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="ht-chip ht-chip-cal" title="Change vs. previous">{{ $weight->difference_string }}</span>

                <div class="dropdown ht-kebab-wrap d-none d-md-block">
                    <button class="ht-kebab" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Weight actions">
                        <i class="feather-20" data-feather="more-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <form action="{{ route('weights.destroy', $weight) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="dropdown-item dropdown-item-delete"><i class="feather-16 align-text-bottom me-2" data-feather="trash-2"></i>Delete weight</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
