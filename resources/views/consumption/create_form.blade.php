<h1>Add a Consumption</h1>

<form class="needs-validation" action="{{ route('consumptions.store') }}" method="post" @keydown.enter.prevent.self novalidate>
    @include('consumption.fields', ['foods' => $foods])

    <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom mr-1" data-feather="plus"></i>Add Consumption</button>

</form>