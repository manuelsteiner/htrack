@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Weight: {{ $weight->weight_string }}</h1>
        <h5>on {{ $weight->date_string }}</h5>

        <div class="mt-2">
            <form action="{{ route('weights.destroy', $weight) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger"><i class="feather-20 align-text-bottom mr-1" data-feather="trash-2"></i>Delete Weight</button>
            </form>
        </div>
    </div>
@endsection