<div class="card mb-1">
    <div class="card-body">
        <a class="stretched-link outline-none d-md-none" href="{{ route('weights.show', $weight) }}"></a>

        <div class="container-fluid">

            <div class="row align-items-center">

                <div class="col flex-grow-1">
                    <a class="stretched-link outline-none d-none d-md-inline" href="{{ route('weights.show', $weight) }}"></a>

                    <p class="m-0">
                        {{ $weight->weight_string }}
                    </p>
                    <p class="m-0 text-muted">
                        on {{ $weight->date_string }}
                    </p>
                </div>

                <div class="col-auto text-right">
                    <div class="badge badge-card-list badge-secondary align-middle d-inline-flex align-items-center justify-content-center">
                        {{ $weight->difference_string }}
                    </div>
                </div>

                <div class="col-md-auto d-none d-md-block">
                    <div class="dropdown d-inline">
                        <button class="btn btn-lg btn-link dropdown-toggle-vertical-points text-muted" type="button" id="foodOverviewDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="foodOverviewDropdown">
                            <form action="{{ route('weights.destroy', $weight) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="dropdown-item dropdown-item-delete"><i class="feather-20 align-text-bottom mr-1" data-feather="trash-2"></i>Delete Weight</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>