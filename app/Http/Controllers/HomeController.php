<?php

namespace App\Http\Controllers;

use App\Models\Consumption;
use Carbon\CarbonPeriod;

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

        $calories = round($consumptions->sum('calories'));
        $calories_target = auth()->user()->settings->calorie_target;
        $calories_left = $calories_target - $calories;
        $calorie_percent = $calories_target > 0 ? min(100, round($calories / $calories_target * 100)) : 0;

        // Macros as numbers, plus each one's share of macro calories (4/9/4 kcal/g) for the bars
        $protein_g = round($consumptions->sum('protein'), 1);
        $fat_g = round($consumptions->sum('fat'), 1);
        $carbs_g = round($consumptions->sum('carbohydrates'), 1);
        $macro_kcal = $protein_g * 4 + $fat_g * 9 + $carbs_g * 4;
        $share = fn ($kcal) => $macro_kcal > 0 ? round($kcal / $macro_kcal * 100) : 0;
        $protein_pct = $share($protein_g * 4);
        $fat_pct = $share($fat_g * 9);
        $carbs_pct = $share($carbs_g * 4);

        $protein_target = auth()->user()->settings->protein_target;

        $sugar = round($consumptions->sum('sugar'), 1).'g';
        $fibre = round($consumptions->sum('fibre'), 1).'g';
        $saturated_fat = round($consumptions->sum('saturated_fat'), 1).'g';
        $sodium = round($consumptions->sum('sodium')).'mg';

        $today = auth()->user()->settings->localised_date;
        $yesterday = $today->copy()->subDay();
        $weekAgo = $yesterday->copy()->subDays(6);

        $recentConsumptions = Consumption::where('user_id', auth()->id())
            ->whereBetween('consumed_at', [$weekAgo, $yesterday])
            ->get()
            ->groupBy(fn ($c) => $c->consumed_at->format('Y-m-d'));

        $calorie_targets = auth()->user()->settings->calorie_targets;

        $days = collect(CarbonPeriod::create($weekAgo, $yesterday))->map(function ($date) use ($recentConsumptions, $calorie_targets) {
            $key = $date->format('Y-m-d');
            $dayConsumptions = $recentConsumptions->get($key, collect());
            $dayTarget = $calorie_targets[strtolower($date->format('l'))] ?? 0;

            return [
                'date' => $date->format('D, d M'),
                'calories' => round($dayConsumptions->sum('calories')),
                'calories_target' => $dayTarget,
                'protein' => round($dayConsumptions->sum('protein'), 1),
                'fat' => round($dayConsumptions->sum('fat'), 1),
                'carbs' => round($dayConsumptions->sum('carbohydrates'), 1),
                'sugar' => round($dayConsumptions->sum('sugar'), 1),
                'sat_fat' => round($dayConsumptions->sum('saturated_fat'), 1),
                'fibre' => round($dayConsumptions->sum('fibre'), 1),
                'sodium' => round($dayConsumptions->sum('sodium')),
            ];
        })->reverse()->values();

        return view('home', [
            'calories' => $calories,
            'calories_left' => $calories_left,
            'calories_target' => $calories_target,
            'calorie_percent' => $calorie_percent,
            'protein_g' => $protein_g,
            'fat_g' => $fat_g,
            'carbs_g' => $carbs_g,
            'protein_pct' => $protein_pct,
            'fat_pct' => $fat_pct,
            'carbs_pct' => $carbs_pct,
            'protein_target' => $protein_target,
            'sugar' => $sugar,
            'fibre' => $fibre,
            'saturated_fat' => $saturated_fat,
            'sodium' => $sodium,
            'days' => $days,
        ]);
    }
}
