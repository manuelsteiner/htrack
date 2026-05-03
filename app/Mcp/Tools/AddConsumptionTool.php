<?php

namespace App\Mcp\Tools;

use App\Models\Consumption;
use App\Models\Food;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('add-consumption')]
#[Description(
    'Log a consumption: an amount of an existing food eaten on a specific date. '
    .'The food must already exist (look it up via list-foods or create it via add-food first). '
    .'"amount" is the quantity actually consumed in grams or millilitres — not a multiple of the food\'s serving size. '
    .'"consumed_at" defaults to the user\'s local "today" if omitted.'
)]
class AddConsumptionTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'food_id' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1',
            'consumed_at' => 'nullable|date_format:Y-m-d',
        ], [
            'consumed_at.date_format' => 'consumed_at must be a date in YYYY-MM-DD format.',
        ]);

        $user = $request->user();

        $food = Food::where('id', $validated['food_id'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->first();

        if (! $food) {
            return Response::error("No food with id {$validated['food_id']} is accessible to this user. Use list-foods to find one or add-food to create it.");
        }

        $consumedAt = $validated['consumed_at']
            ?? ($user->settings?->localised_date_string ?? now()->toDateString());

        $consumption = $user->consumptions()->create([
            'food_id' => $food->id,
            'amount' => $validated['amount'],
            'consumed_at' => $consumedAt,
        ]);

        $consumption->setRelation('food', $food);

        return Response::make(
            Response::text(sprintf(
                'Logged %s g/ml of "%s" on %s (consumption id %d).',
                $consumption->amount,
                $food->name,
                $consumedAt,
                $consumption->id,
            ))
        )->withStructuredContent([
            'consumption' => $this->consumptionToArray($consumption),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'food_id' => $schema->integer()
                ->description('ID of an existing food (returned by list-foods or add-food).')
                ->required(),

            'amount' => $schema->number()
                ->description('Amount consumed in grams or millilitres. Minimum 1.')
                ->required(),

            'consumed_at' => $schema->string()
                ->description('Date of consumption in YYYY-MM-DD format. Defaults to the user\'s local "today" if omitted.'),
        ];
    }

    private function consumptionToArray(Consumption $c): array
    {
        return [
            'id' => $c->id,
            'consumed_at' => $c->consumed_at?->toDateString(),
            'amount' => (float) $c->amount,
            'food' => [
                'id' => $c->food->id,
                'name' => $c->food->name,
            ],
            'calories' => $c->calories,
            'carbohydrates' => $c->carbohydrates,
            'sugar' => $c->sugar,
            'fibre' => $c->fibre,
            'fat' => $c->fat,
            'saturated_fat' => $c->saturated_fat,
            'protein' => $c->protein,
            'sodium' => $c->sodium,
        ];
    }
}
