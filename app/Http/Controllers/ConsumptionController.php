<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Consumption;
use Illuminate\Http\Request;

class ConsumptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        $consumptions = Consumption::filter($request->input())->order($request->input())->with('food')->paginate(13)->appends($request->except('page'));
        $foods = Food::orderByRaw('name COLLATE NOCASE')->get();

        return view('consumption.index', ['consumptions' => $consumptions, 'foods' => $foods->toJson()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foods = Food::orderByRaw('name COLLATE NOCASE')->get();

        return view('consumption.create', ['foods' => $foods->toJson()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filled('food_id')) {
            $validatedData = $request->validate([
                'consumed_at' => 'required|date',
                'amount' => 'required|numeric|min:1',
                'food_id' => 'required|integer|min:1',
            ]);

            $food = Food::find($request->food_id);

            if ($food) {
                $consumption = Consumption::make($validatedData);

                auth()->user()->consumptions()->save($consumption);

                return redirect()->route('consumptions.index')->with('success', 'The consumption was successfully added.');
            } else {
                return redirect()->route('consumptions.index')->with('danger', 'The food item specified does not exist.');
            }
        } else {
            $request->validate([
                'consumed_at' => 'required|date',
                'amount' => 'required|numeric|min:1',
                'name' => 'required',
                'serving_size' => 'nullable|integer|min:1',
                'calories' => 'nullable|numeric|min:0',
                'carbohydrates' => 'nullable|numeric|min:0',
                'sugar' => 'nullable|numeric|min:0',
                'fibre' => 'nullable|numeric|min:0',
                'fat' => 'nullable|numeric|min:0',
                'saturated_fat' => 'nullable|numeric|min:0',
                'protein' => 'nullable|numeric|min:0',
                'sodium' => 'nullable|numeric|min:0',
            ]);

            $consumptionData = $request->only(['consumed_at', 'amount']);
            $foodData = $request->only(['name', 'serving_size', 'calories', 'carbohydrates', 'sugar', 'fibre', 'fat', 'saturated_fat', 'protein', 'sodium']);

            $food = Food::where($foodData)->first();

            if ($food) {
                $consumption = Consumption::make($consumptionData);
                $consumption->food_id = $food->id;

                auth()->user()->consumptions()->save($consumption);

                return redirect()->route('consumptions.index')->with('info', 'A food item with this name and nutritional values exists already. The consumption was added to that food.');
            } else {
                $food = Food::make($foodData);

                auth()->user()->foods()->save($food);

                $consumption = Consumption::make($consumptionData);
                $consumption->food_id = $food->id;

                auth()->user()->consumptions()->save($consumption);

                return redirect()->route('consumptions.index')->with('success', 'The food item and consumption were successfully added.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function show(Consumption $consumption)
    {
        return view('consumption.show', compact('consumption'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumption $consumption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consumption $consumption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consumption  $consumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consumption $consumption)
    {
        $consumption->delete();

        return redirect()->route('consumptions.index')->with('success', 'The consumption was successfully deleted.');
    }
}
