<?php

namespace App\Http\Controllers;

use App\Models\Consumption;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $consumptions = Consumption::where('consumed_at', auth()->user()->settings->localised_date)->get();

        $calories = $consumptions->sum('calories');
        $calories_target = auth()->user()->settings->calorie_target;
        $calories_left = $calories_target - $calories;
        $carbohydrates = $consumptions->sum('carbohydrates').'g';
        $fat = $consumptions->sum('fat').'g';
        $protein = $consumptions->sum('protein').'g';

        return view('home', ['calories' => $calories, 'calories_left' => $calories_left, 'calories_target' => $calories_target, 'carbohydrates' => $carbohydrates, 'fat' => $fat, 'protein' => $protein]);
    }
}
