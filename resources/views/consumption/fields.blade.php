@csrf

<input type="hidden" name="food_id" :value="selected_id" :disabled="!existing_food_selected" />
<input type="hidden" name="name" :value="selected_name" :disabled="existing_food_selected" />

<div class="row g-3 align-items-end">

    <div class="col-12 col-md-5">
        <label for="food_name" class="form-label">Food name</label>
        <v-select :options="{{ $foods }}" @option:selected="onSelectionChange" @option:deselected="onSelectionChange(null)" class="@error('food_name') is-invalid @enderror" id="food_name" label="name" placeholder="Consumed food" select-on-tab taggable>
            <template #search="{attributes, events}">
                <input class="vs__search" :required="!selected_name"  v-bind="attributes"  v-on="events" />
            </template>
        </v-select>
        <div class="invalid-feedback">
            @error('food_name')
            {{ $message }}
            @else
                Please select a food or enter a new food name.
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-2">
        <label for="consumed_at" class="form-label">Date</label>
        <input type="date" class="form-control @error('consumed_at') is-invalid @enderror" id="consumed_at" name="consumed_at" placeholder="Consumed at" value="{{ old('consumed_at', Auth::user()->settings->localised_date_string) }}" required />
        <div class="invalid-feedback">
            @error('consumed_at')
            {{ $message }}
            @else
                Please select the consumption date.
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-2">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" min="1" step="0.1" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount in g/ml" value="{{ old('amount') }}" required />
        <div class="invalid-feedback">
            @error('amount')
            {{ $message }}
            @else
                Please enter the amount.
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-3">
        <button type="button" class="btn btn-outline-secondary w-100" @click="onDetailsClick" :disabled="disable_details_button"><i class="feather-20 align-text-bottom me-1" data-feather="info"></i>Details</button>
    </div>

</div>

<div :class="details" v-cloak>

    <div class="ht-eyebrow mt-4 mb-2">Per 100 g / ml</div>

    <div class="row g-3">

        <div class="col-6 col-md-3">
            <label for="serving_size" class="form-label">Serving size</label>
            <input type="number" min="1" step="0.1" class="form-control" id="serving_size" name="serving_size" placeholder="Serving size in g/ml" :value="selected_serving_size" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="calories" class="form-label">Calories</label>
            <input type="number" min="1" step="0.1" class="form-control" id="calories" name="calories" placeholder="kcal" :value="selected_calories" required :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="carbohydrates" class="form-label">Carbohydrates</label>
            <input type="number" min="0" step="0.1" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="g" :value="selected_carbohydrates" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="sugar" class="form-label">Sugar</label>
            <input type="number" min="0" step="0.1" class="form-control" id="sugar" name="sugar" placeholder="g" :value="selected_sugar" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="fibre" class="form-label">Fibre</label>
            <input type="number" min="0" step="0.1" class="form-control" id="fibre" name="fibre" placeholder="g" :value="selected_fibre" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="fat" class="form-label">Fat</label>
            <input type="number" min="0" step="0.1" class="form-control" id="fat" name="fat" placeholder="g" :value="selected_fat" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="saturated_fat" class="form-label">Saturated fat</label>
            <input type="number" min="0" step="0.1" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="g" :value="selected_saturated_fat" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="protein" class="form-label">Protein</label>
            <input type="number" min="0" step="0.1" class="form-control" id="protein" name="protein" placeholder="g" :value="selected_protein" :disabled="existing_food_selected" />
        </div>

        <div class="col-6 col-md-3">
            <label for="sodium" class="form-label">Sodium</label>
            <input type="number" min="0" step="0.1" class="form-control" id="sodium" name="sodium" placeholder="mg" :value="selected_sodium" :disabled="existing_food_selected" />
        </div>

    </div>

</div>
