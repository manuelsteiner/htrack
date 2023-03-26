@csrf

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="consumed_at">Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" placeholder="Date" value="{{ old('date', Auth::user()->settings->localised_date_string) }}" required />
        <div class="invalid-feedback">
            @error('date')
                {{ $message }}
            @else
                Please select a date.
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="weight">Amount</label>
        <input type="number" min="1" step="0.1" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" placeholder="Weight in kg" value="{{ old('weight') }}" required />
        <div class="invalid-feedback">
            @error('weight')
                {{ $message }}
            @else
                Please enter the weight in kg.
            @enderror
        </div>
    </div>

</div>