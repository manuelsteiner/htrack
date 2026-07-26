<form class="needs-validation" action="{{ route('consumptions.store') }}" method="post" @keydown.enter.prevent.self novalidate>
    @include('consumption.fields', ['foods' => $foods])

    <button type="submit" class="btn btn-primary mt-4"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add consumption</button>

</form>
