<form class="needs-validation" action="{{ route('foods.store') }}" method="post" novalidate>
    @include('food.fields')

    <button type="submit" class="btn btn-primary mt-4"><i class="feather-20 align-text-bottom me-1" data-feather="plus"></i>Add food item</button>

</form>
