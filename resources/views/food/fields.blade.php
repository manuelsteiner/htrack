@csrf

<div class="row g-3 mb-2">

    <div class="col-12 col-md-8">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g. Greek yoghurt" value="{{ old('name') }}" required />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter a name.
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <label for="serving_size" class="form-label">Serving size</label>
        <input type="number" min="1" step="0.1" class="form-control" id="serving_size" name="serving_size" placeholder="Serving size in g/ml" value="{{ old('serving_size') }}" />
        <div class="invalid-feedback">
            Please enter an optional serving size greater 0.
        </div>
    </div>

</div>

<div class="ht-eyebrow mt-3 mb-2">Per 100 g / ml</div>

<div class="row g-3">

    <div class="col-6 col-md-3">
        <label for="calories" class="form-label">Calories</label>
        <input type="number" min="1" step="0.1" class="form-control @error('calories') is-invalid @enderror" id="calories" name="calories" placeholder="kcal" value="{{ old('calories') }}" required />
        <div class="invalid-feedback">
            @error('calories')
                {{ $message }}
            @else
                Please enter the calories greater 0.
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-3">
        <label for="carbohydrates" class="form-label">Carbohydrates</label>
        <input type="number" min="0" step="0.1" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="g" value="{{ old('carbohydrates') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="sugar" class="form-label">Sugar</label>
        <input type="number" min="0" step="0.1" class="form-control" id="sugar" name="sugar" placeholder="g" value="{{ old('sugar') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="fibre" class="form-label">Fibre</label>
        <input type="number" min="0" step="0.1" class="form-control" id="fibre" name="fibre" placeholder="g" value="{{ old('fibre') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="fat" class="form-label">Fat</label>
        <input type="number" min="0" step="0.1" class="form-control" id="fat" name="fat" placeholder="g" value="{{ old('fat') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="saturated_fat" class="form-label">Saturated fat</label>
        <input type="number" min="0" step="0.1" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="g" value="{{ old('saturated_fat') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="protein" class="form-label">Protein</label>
        <input type="number" min="0" step="0.1" class="form-control" id="protein" name="protein" placeholder="g" value="{{ old('protein') }}" />
    </div>

    <div class="col-6 col-md-3">
        <label for="sodium" class="form-label">Sodium</label>
        <input type="number" min="0" step="0.1" class="form-control" id="sodium" name="sodium" placeholder="mg" value="{{ old('sodium') }}" />
    </div>

</div>
