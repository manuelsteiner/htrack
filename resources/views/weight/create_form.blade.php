<form class="needs-validation" action="{{ route('weights.store') }}" method="post" novalidate>
    @include('weight.fields')

    <button type="submit" class="btn btn-primary mt-4"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add weight</button>

</form>
