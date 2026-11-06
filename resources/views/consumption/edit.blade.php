@extends('layouts.app')

@section('content')
    <div class="container px-3 px-md-4" style="max-width: 1180px;">

        <a href="{{ route('consumptions.show', $consumption) }}" class="d-inline-flex align-items-center gap-1 text-decoration-none text-body-secondary mb-3" style="font-size:.8125rem;">
            <i class="feather-16" data-feather="chevron-left"></i>Back to consumption
        </a>

        <h1 class="ht-page-title mb-1">Edit consumption</h1>
        <div class="text-body-tertiary mb-4" style="font-size:.8125rem;">{{ $consumption->food->name }} · {{ $consumption->amount_string }} · {{ $consumption->consumed_at_string }}</div>

        {{-- Pre-selects the current food in the v-select (read by the Vue root on boot). --}}
        <script type="application/json" id="ht-initial-food">@json(old('food_id') ? \App\Models\Food::find(old('food_id')) : $consumption->food)</script>

        <div class="card">
            <div class="card-body p-4">
                <form class="needs-validation" action="{{ route('consumptions.update', $consumption) }}" method="post" @keydown.enter.prevent.self novalidate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="food_id" :value="selected_id" />

                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-md-6">
                            <label for="food_name" class="form-label">Food</label>
                            <v-select v-model="selected" :options="{{ $foods }}" :clearable="false" class="@error('food_id') is-invalid @enderror" id="food_name" label="name" placeholder="Consumed food" select-on-tab></v-select>
                            <div class="invalid-feedback">
                                @error('food_id')
                                    {{ $message }}
                                @else
                                    Please select a food.
                                @enderror
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <label for="consumed_at" class="form-label">Date</label>
                            <input type="date" class="form-control @error('consumed_at') is-invalid @enderror" id="consumed_at" name="consumed_at" value="{{ old('consumed_at', $consumption->consumed_at->toDateString()) }}" required />
                            <div class="invalid-feedback">
                                @error('consumed_at')
                                    {{ $message }}
                                @else
                                    Please select the consumption date.
                                @enderror
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" min="1" step="0.1" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount in g/ml" value="{{ old('amount', (float) $consumption->amount) }}" required />
                            <div class="invalid-feedback">
                                @error('amount')
                                    {{ $message }}
                                @else
                                    Please enter the amount.
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="text-body-tertiary mt-3" style="font-size:.8125rem;">
                        To change the nutritional values, <a href="{{ route('foods.edit', $consumption->food) }}">edit the food item</a> instead.
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="feather-20 align-text-bottom me-1" data-feather="check"></i>Save changes</button>
                        <a class="btn btn-outline-secondary" href="{{ route('consumptions.show', $consumption) }}" role="button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
