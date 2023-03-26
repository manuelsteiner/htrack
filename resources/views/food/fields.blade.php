@csrf

<div class="form-row">

    <div class="form-group col-md-9">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter a name.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="serving_size">Serving size</label>
        <input type="number" min="1" step="0.1" class="form-control" id="serving_size" name="serving_size" placeholder="Serving size in g/ml" value="{{ old('serving_size') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter an optional serving size greater 0.
            @enderror
        </div>
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="calories">Calories</label>
        <input type="number" min="1" step="0.1" class="form-control" id="calories" name="calories" placeholder="Calories per 100g/ml" value="{{ old('calories') }}" required />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the calories greater 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="carbohydrates">Carbohydrates</label>
        <input type="number" min="0" step="0.1" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="Carbohydrates per 100g/ml" value="{{ old('carbohydrates') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional carbohydrates, at least 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="sugar">Sugar</label>
        <input type="number" min="0" step="0.1" class="form-control" id="sugar" name="sugar" placeholder="Sugar per 100g/ml" value="{{ old('sugar') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional sugar, at least 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="fibre">Fibre</label>
        <input type="number" min="0" step="0.1" class="form-control" id="fibre" name="fibre" placeholder="Fibre per 100g/ml" value="{{ old('fibre') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional fibre, at least 0.
            @enderror
        </div>
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="fat">Fat</label>
        <input type="number" min="0" step="0.1" class="form-control" id="fat" name="fat" placeholder="Fat per 100g/ml" value="{{ old('fat') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional fat, at least 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="saturated_fat">Saturated fat</label>
        <input type="number" min="0" step="0.1" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="Saturated fat per 100g/ml" value="{{ old('saturated_fat') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional saturated fat, at least 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="protein">Protein</label>
        <input type="number" min="0" step="0.1" class="form-control" id="protein" name="protein" placeholder="Protein per 100g/ml" value="{{ old('protein') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional protein, at least 0.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="sodium">Sodium</label>
        <input type="number" min="0" step="0.1" class="form-control" id="sodium" name="sodium" placeholder="Sodium in mg per 100g/ml" value="{{ old('sodium') }}" />
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @else
                Please enter the optional sodium, at least 0.
            @enderror
        </div>
    </div>

</div>