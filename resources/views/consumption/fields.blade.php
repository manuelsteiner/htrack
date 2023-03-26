@csrf

<input type="hidden" name="food_id" :value="selected_id" :disabled="!existing_food_selected" />
<input type="hidden" name="name" :value="selected_name" :disabled="existing_food_selected" />


<div class="form-row">

    <div class="form-group col-md-6">
        <label for="food_name">Food name</label>
        <v-select :options="{{ $foods }}" @input="onSelectionChange" class="@error('food_name') is-invalid @enderror" id="food_name" label="name" placeholder="Consumed food" select-on-tab taggable>
            <template #search="{attributes, events}">
                <input class="vs__search" :required="!selected_name"  v-bind="attributes"  v-on="events" />
            </template>
        </v-select>
        <div class="invalid-feedback">
            @error('food_name')
            {{ $message }}
            @else
                Please select a food or anter a new food name.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-2">
        <label for="consumed_at">Date</label>
        <input type="date" class="form-control @error('consumed_at') is-invalid @enderror" id="consumed_at" name="consumed_at" placeholder="Consumed at" value="{{ old('consumed_at', Auth::user()->settings->localised_date_string) }}" required />
        <div class="invalid-feedback">
            @error('name')
            {{ $message }}
            @else
                Please select the consumption date.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-2">
        <label for="amount">Amount</label>
        <input type="number" min="1" step="0.1" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount in g/ml" value="{{ old('amount') }}" required />
        <div class="invalid-feedback">
            @error('amount')
            {{ $message }}
            @else
                Please enter the amount.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-2">
        <label>&nbsp;</label>
        <button type="button" class="form-control btn btn-outline-secondary" @click="onDetailsClick" :disabled="disable_details_button"><i class="feather-20 align-text-bottom mr-1" data-feather="info"></i>Details</button>
    </div>

</div>

<div :class="details" v-cloak>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="serving_size">Serving size</label>
            <input type="number" min="1" step="0.1" class="form-control" id="serving_size" name="serving_size" placeholder="Serving size in g/ml" :value="selected_serving_size" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter an optional serving size greater 0.
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="calories">Calories</label>
            <input type="number" min="1" step="0.1" class="form-control" id="calories" name="calories" placeholder="Calories per 100g/ml" :value="selected_calories" required :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the calories greater 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="carbohydrates">Carbohydrates</label>
            <input type="number" min="0" step="0.1" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="Carbohydrates per 100g/ml" :value="selected_carbohydrates" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional carbohydrates, at least 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="sugar">Sugar</label>
            <input type="number" min="0" step="0.1" class="form-control" id="sugar" name="sugar" placeholder="Sugar per 100g/ml" :value="selected_sugar" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional sugar, at least 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="fibre">Fibre</label>
            <input type="number" min="0" step="0.1" class="form-control" id="fibre" name="fibre" placeholder="Fibre per 100g/ml" :value="selected_fibre" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional fibre, at least 0.
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="fat">Fat</label>
            <input type="number" min="0" step="0.1" class="form-control" id="fat" name="fat" placeholder="Fat per 100g/ml" :value="selected_fat" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional fat, at least 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="saturated_fat">Saturated fat</label>
            <input type="number" min="0" step="0.1" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="Saturated fat per 100g/ml" :value="selected_saturated_fat" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional saturated fat, at least 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="protein">Protein</label>
            <input type="number" min="0" step="0.1" class="form-control" id="protein" name="protein" placeholder="Protein per 100g/ml" :value="selected_protein" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional protein, at least 0.
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="sodium">Sodium</label>
            <input type="number" min="0" step="0.1" class="form-control" id="sodium" name="sodium" placeholder="Sodium in mg per 100g/ml" :value="selected_sodium" :disabled="existing_food_selected" />
            <div class="invalid-feedback">
                Please enter the optional sodium, at least 0.
            </div>
        </div>

    </div>

</div>