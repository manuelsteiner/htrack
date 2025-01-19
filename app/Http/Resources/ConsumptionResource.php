<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Consumption */
class ConsumptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'consumed_at' => $this->consumed_at,
            'amount' => $this->amount,
            'calories' => $this->calories,
            'carbohydrates' => $this->carbohydrates,
            'sugar' => $this->sugar,
            'fibre' => $this->fibre,
            'fat' => $this->fat,
            'saturated_fat' => $this->saturated_fat,
            'protein' => $this->protein,
            'sodium' => $this->sodium
        ];
    }
}
