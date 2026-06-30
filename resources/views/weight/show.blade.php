@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <a href="{{ route('weights.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-body-secondary mb-3" style="font-size:.8125rem;">
            <i class="feather-16" data-feather="chevron-left"></i>Back to weight
        </a>

        <h1 class="ht-page-title mb-1">{{ $weight->weight_string }}</h1>
        <div class="text-body-tertiary mb-4" style="font-size:.8125rem;">{{ $weight->date_string }}</div>

        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="ht-stat-num">{{ $weight->weight_string }}</div>
                        <div class="text-body-tertiary mt-1" style="font-size:.75rem;">Weight</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="ht-stat-num">{{ $weight->difference_string }}</div>
                        <div class="text-body-tertiary mt-1" style="font-size:.75rem;">Change vs. previous</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <form action="{{ route('weights.destroy', $weight) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger"><i class="feather-20 align-text-bottom me-1" data-feather="trash-2"></i>Delete weight</button>
            </form>
        </div>
    </div>
@endsection
