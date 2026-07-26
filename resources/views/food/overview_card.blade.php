<div class="card ht-list-row">
    <div class="card-body py-3 px-4 position-relative">
        <a class="stretched-link outline-none" href="{{ route('foods.show', $food) }}" aria-label="{{ $food->name }}"></a>

        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="fw-semibold" style="font-size:15px;">{{ $food->name }}</div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <span class="ht-chip ht-chip-cal">{{ $food->calories }}</span>
                    <span class="ht-chip ht-chip-pro">{{ $food->protein_string }}</span>
                    <span class="ht-chip ht-chip-fat">{{ $food->fat_string }}</span>
                    <span class="ht-chip ht-chip-carb">{{ $food->carbohydrates_string }}</span>
                </div>

                <div class="dropdown ht-kebab-wrap d-none d-md-block">
                    <button class="ht-kebab" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Food actions">
                        <i class="feather-20" data-feather="more-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('foods.edit', $food) }}"><i class="feather-16 align-text-bottom me-2" data-feather="edit"></i>Edit food item</a>

                        <form action="{{ route('foods.destroy', $food) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="dropdown-item dropdown-item-delete @if($food->consumptions_count) disabled @endif"><i class="feather-16 align-text-bottom me-2" data-feather="trash-2"></i>Delete food item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
