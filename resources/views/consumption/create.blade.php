@extends('layouts.app')

@section('content')
    <div class="container">
        @include('consumption.create_form', ['foods' => $foods])
    </div>
@endsection