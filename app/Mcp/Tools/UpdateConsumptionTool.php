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
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;

#[Name('update-consumption')]
#[IsIdempotent]
#[Description(
    'Correct a logged consumption: change its amount (g/ml), its date, or the food it refers to. '
    .'Only the fields you pass are changed. Find the consumption id with list-consumptions. '
    .'This does not change the food\'s nutritional values; use update-food for that.'
)]
class UpdateConsumptionTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $allowed = ['consumption_id', 'food_id', 'amount', 'consumed_at'];
        $unknown = array_diff(array_keys($request->all()), $allowed);

        if ($unknown !== []) {
            return Response::error(sprintf(
                'Unknown field(s): %s. Accepted fields: %s.',
                implode(', ', $unknown),
                implode(', ', $allowed),
            ));
        }

        $validated = $request->validate([
            'consumption_id' => 'required|integer|min:1',
            'food_id' => 'sometimes|required|integer|min:1',
            'amount' => 'sometimes|required|numeric|min:1',
            'consumed_at' => 'sometimes|required|date_format:Y-m-d',
        ], [
            'consumed_at.date_format' => 'consumed_at must be a date in YYYY-MM-DD format.',
        ]);

        $user = $request->user();

        $consumption = Consumption::where('id', $validated['consumption_id'])
            ->where('user_id', $user->id)
            ->with('food')
            ->first();

        if (! $consumption) {
            return Response::error("No consumption with id {$validated['consumption_id']} belongs to this user. Use list-consumptions to find it.");
        }

        $changes = collect($validated)->except('consumption_id')->all();

        if ($changes === []) {
            return Response::error('Nothing to update. Pass at least one of amount, consumed_at or food_id.');
        }

        if (isset($changes['food_id'])) {
            $food = Food::where('id', $changes['food_id'])
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)->orWhereNull('user_id');
                })
                ->first();

            if (! $food) {
                return Response::error("No food with id {$changes['food_id']} is accessible to this user. Use list-foods to find one or add-food to create it.");
            }
        }

        $before = $this->summary($consumption);

        $consumption->update($changes);
        $consumption->refresh()->load('food');

        return Response::make(
            Response::text(sprintf(
                'Updated consumption #%d: was %s, now %s.',
                $consumption->id,
                $before,
                $this->summary($consumption),
            ))
        )->withStructuredContent([
            'consumption' => [
                'id' => $consumption->id,
                'consumed_at' => $consumption->consumed_at?->toDateString(),
                'amount' => (float) $consumption->amount,
                'food' => [
                    'id' => $consumption->food->id,
                    'name' => $consumption->food->name,
                ],
                'calories' => $consumption->calories,
                'carbohydrates' => $consumption->carbohydrates,
                'sugar' => $consumption->sugar,
                'fibre' => $consumption->fibre,
                'fat' => $consumption->fat,
                'saturated_fat' => $consumption->saturated_fat,
                'protein' => $consumption->protein,
                'sodium' => $consumption->sodium,
            ],
        ]);
    }

    private function summary(Consumption $c): string
    {
        return sprintf('%s g/ml of "%s" on %s', (float) $c->amount, $c->food->name, $c->consumed_at->toDateString());
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'consumption_id' => $schema->integer()
                ->description('ID of the consumption to update (from list-consumptions).')
                ->required(),

            'amount' => $schema->number()
                ->description('New amount consumed in grams or millilitres. Minimum 1.'),

            'consumed_at' => $schema->string()
                ->description('New date of consumption in YYYY-MM-DD format.'),

            'food_id' => $schema->integer()
                ->description('ID of a different existing food, if the wrong food was logged.'),
        ];
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['inputSchema']['additionalProperties'] = false;

        return $array;
    }
}
