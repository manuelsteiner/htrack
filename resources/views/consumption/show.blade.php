@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Consumption: {{ $consumption->food->name }}</h1>
        <h5>{{ $consumption->amount_string }} on {{ $consumption->consumed_at_string }}</h5>

        <div class="mt-2">
            <form action="{{ route('consumptions.destroy', $consumption) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger"><i class="feather-20 align-text-bottom mr-1" data-feather="trash-2"></i>Delete Consumption</button>
            </form>
        </div>
    </div>
@endsection