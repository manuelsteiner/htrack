<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
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

        $foods = Food::filter($request->input())->order($request->input())->withCount('consumptions')->paginate(14)->appends($request->except('page'));

        return view('food.index', ['foods' => $foods]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

        if (Food::where($validatedData)->exists()) {
            return redirect()->route('foods.index')->with('info', 'A food item with this name and nutritional values exists already.');
        }

        $food = Food::make($validatedData);

        auth()->user()->foods()->save($food);

        return redirect()->route('foods.index')->with('success', 'The food item was successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        $food->loadCount('consumptions');

        return view('food.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('foods.index')->with('success', 'The food item was successfully deleted.');
    }
}
