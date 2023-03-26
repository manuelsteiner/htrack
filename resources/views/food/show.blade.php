@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Food: {{ $food->name }}</h1>

        <div class="mt-2"></div>
            <a class="btn btn-primary" href="{{ route('foods.edit', $food) }}" role="button"><i class="feather-20 align-text-bottom mr-1" data-feather="edit"></i>Edit Food Item</a>
            <form class="d-inline ml-2" action="{{ route('foods.destroy', $food) }}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger" @if($food->consumptions_count) disabled @endif><i class="feather-20 align-text-bottom mr-1" data-feather="trash-2"></i>Delete Food Item</button>
            </form>
        </div>
    </div>
@endsection