@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">
        <h1 class="ht-page-title mb-4">Add a consumption</h1>

        <div class="card">
            <div class="card-body p-4">
                @include('consumption.create_form', ['foods' => $foods])
            </div>
        </div>
    </div>
@endsection
