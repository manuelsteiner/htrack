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
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('delete-food')]
#[IsDestructive]
#[Description(
    'Permanently delete a food item from the user\'s food database. '
    .'Only foods that are not used by any consumption can be deleted; otherwise the call fails and reports how many consumptions use it. '
    .'To get rid of a wrong food that is in use, first move those consumptions to another food with update-consumption (or delete them with delete-consumption). '
    .'To fix wrong values, use update-food instead of deleting. Confirm with the user before deleting.'
)]
class DeleteFoodTool extends Tool
{
    use HandlesFoodFields;

    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'food_id' => 'required|integer|min:1',
        ]);

        $food = Food::where('id', $validated['food_id'])
            ->where('user_id', $request->user()->id)
            ->withCount('consumptions')
            ->first();

        if (! $food) {
            return Response::error("No food with id {$validated['food_id']} belongs to this user. Use list-foods to find it.");
        }

        if ($food->consumptions_count > 0) {
            return Response::error(sprintf(
                "Food '%s' (id %d) is used by %d %s and cannot be deleted. Move them to another food with update-consumption or delete them first, or use update-food to correct its values.",
                $food->name,
                $food->id,
                $food->consumptions_count,
                $food->consumptions_count === 1 ? 'consumption' : 'consumptions',
            ));
        }

        $deleted = $this->foodToArray($food);
        $food->delete();

        return Response::make(
            Response::text("Deleted food '{$deleted['name']}' (id {$deleted['id']}).")
        )->withStructuredContent([
            'deleted' => true,
            'food' => $deleted,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'food_id' => $schema->integer()
                ->description('ID of the food to delete (from list-foods).')
                ->required(),
        ];
    }
}
