<h1>Add a Food Item</h1>

<form class="needs-validation" action="{{ route('foods.store') }}" method="post" novalidate>
    @include('food.fields')

    <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom mr-1" data-feather="plus"></i>Add Food Item</button>

</form>