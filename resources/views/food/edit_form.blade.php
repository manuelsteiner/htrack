<h1>Add a Food Item</h1>

<form class="needs-validation" action="{{ route('foods.edit') }}" method="post" novalidate>
    @include('food.fields)

    <button type="submit" class="btn btn-primary">Save Food</button>

</form>