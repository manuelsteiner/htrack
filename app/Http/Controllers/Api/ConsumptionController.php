<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumptionResource;
use App\Models\Consumption;
use Illuminate\Support\Facades\Auth;

class ConsumptionController extends Controller
{
    public function totalsToday()
    {
        $user = Auth::user();
        $consumptions = Consumption::where('consumed_at', $user->settings->localised_date)->get();

        return response()->json([
            'calories' => $consumptions->sum('calories'),
            'carbohydrates' => $consumptions->sum('carbohydrates'),
            'sugar' => $consumptions->sum('sugar'),
            'fibre' => $consumptions->sum('fibre'),
            'fat' => $consumptions->sum('fat'),
            'saturated_fat' => $consumptions->sum('saturated_fat'),
            'protein' => $consumptions->sum('protein'),
            'sodium' => $consumptions->sum('sodium')
        ]);

    }
}
