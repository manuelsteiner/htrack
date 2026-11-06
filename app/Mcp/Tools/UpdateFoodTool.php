<?php

namespace App\Mcp\Tools;

use App\Mcp\Tools\Concerns\HandlesFoodFields;
use App\Models\Food;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;

#[Name('update-food')]
#[IsIdempotent]
#[Description(
    'Correct an existing food item. Only the fields you pass are changed; pass null to clear an optional value. '
    .'Values are per 100 g (or 100 ml). Field names are fixed: use "fibre" (British spelling) and "sodium" in mg; unknown fields are rejected. '
    .'Every consumption logged with this food is recalculated from the new values, so past daily totals change too. '
    .'Use this to fix wrong values, not to log a different product: for that, create a new food with add-food.'
)]
class UpdateFoodTool extends Tool
{
    use HandlesFoodFields;

    public function handle(Request $request): Response|ResponseFactory
    {
        [$notes, $error] = $this->normaliseFoodArguments($request, ['food_id']);

        if ($error !== null) {
            return Response::error($error);
        }

        $validated = $request->validate(
            [
                'food_id' => 'required|integer|min:1',
                'name' => 'sometimes|required|string|max:255',
            ] + array_map(fn ($rule) => 'sometimes|'.$rule, $this->foodFieldRules())
        );

        $user = $request->user();

        $food = Food::where('id', $validated['food_id'])->where('user_id', $user->id)->first();

        if (! $food) {
            return Response::error("No food with id {$validated['food_id']} belongs to this user. Use list-foods to find it.");
        }

        $changes = collect($validated)->except('food_id')->all();

        if ($changes === []) {
            return Response::error('Nothing to update. Pass at least one field to change, e.g. {"food_id": '.$food->id.', "fibre": 3.2}.');
        }

        $duplicate = Food::where('id', '!=', $food->id)
            ->where(array_merge($food->only(static::$foodFields), $changes))
            ->first();

        if ($duplicate) {
            return Response::error("These values would make this food identical to food #{$duplicate->id} ('{$duplicate->name}'). Log consumptions against that food instead, or change the name.");
        }

        $before = $this->foodToArray($food);
        $food->update($changes);
        $after = $this->foodToArray($food->refresh());

        $changed = collect($changes)
            ->keys()
            ->filter(fn ($key) => $before[$key] !== $after[$key])
            ->map(fn ($key) => sprintf('%s: %s → %s', $key, $before[$key] ?? 'null', $after[$key] ?? 'null'))
            ->values()
            ->all();

        $consumptionCount = $food->consumptions()->count();

        $text = $changed === []
            ? "Food '{$food->name}' (id {$food->id}) already had these values; nothing changed."
            : sprintf(
                "Updated food '%s' (id %d): %s. %d logged %s now use the new values.",
                $food->name,
                $food->id,
                implode(', ', $changed),
                $consumptionCount,
                $consumptionCount === 1 ? 'consumption' : 'consumptions',
            );

        if ($notes !== []) {
            $text .= ' Note: '.implode('; ', $notes).'.';
        }

        return Response::make(Response::text($text))->withStructuredContent([
            'food' => $after,
            'changed_fields' => array_values(array_filter(array_keys($changes), fn ($key) => $before[$key] !== $after[$key])),
            'affected_consumptions' => $consumptionCount,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'food_id' => $schema->integer()
                ->description('ID of the food to update (from list-foods).')
                ->required(),
        ] + $this->foodFieldSchema($schema);
    }
}
