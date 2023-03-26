<h1>Add a Weight</h1>

<form class="needs-validation" action="{{ route('weights.store') }}" method="post" novalidate>
    @include('weight.fields')

    <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom mr-1" data-feather="plus"></i>Add Weight</button>

</form>