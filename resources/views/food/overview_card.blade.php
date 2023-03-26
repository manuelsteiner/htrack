<div class="card mb-1">
    <div class="card-body">
        <a class="stretched-link outline-none d-md-none" href="{{ route('foods.show', $food) }}"></a>

        <div class="container-fluid">

            <div class="row align-items-center">

                <div class="col flex-grow-1">
                    <a class="stretched-link outline-none d-none d-md-inline" href="{{ route('foods.show', $food) }}"></a>

                    <p class="m-0">
                        {{ $food->name }}
                    </p>
                </div>

                <div class="col-md-auto text-left text-md-right">
                    <div class="badge badge-card-list badge-secondary align-middle d-inline-flex align-items-center justify-content-center">
                        {{  $food->calories }}
                    </div>
                    <div class="badge badge-card-list badge-success align-middle d-inline-flex align-items-center justify-content-center">
                        {{  $food->protein_string }}
                    </div>
                    <div class="badge badge-card-list badge-info align-middle d-inline-flex align-items-center justify-content-center">
                        {{  $food->fat_string }}
                    </div>
                    <div class="badge badge-card-list badge-danger align-middle d-inline-flex align-items-center justify-content-center">
                        {{  $food->carbohydrates_string }}
                    </div>
                </div>

                <div class="col-md-auto d-none d-md-block">
                    <div class="dropdown d-inline">
                        <button class="btn btn-lg btn-link dropdown-toggle-vertical-points text-muted" type="button" id="foodOverviewDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="foodOverviewDropdown">
                            <a class="dropdown-item" href="{{ route('foods.edit', $food) }}"><i class="feather-20 align-text-bottom mr-1" data-feather="edit"></i>Edit Food Item</a>

                            <form action="{{ route('foods.destroy', $food) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="dropdown-item dropdown-item-delete @if($food->consumptions_count) disabled @endif"><i class="feather-20 align-text-bottom mr-1" data-feather="trash-2"></i>Delete Food Item</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>