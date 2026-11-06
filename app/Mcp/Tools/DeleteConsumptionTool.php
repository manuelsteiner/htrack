<?php

namespace App\Mcp\Tools;

use App\Models\Consumption;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;

#[Name('delete-consumption')]
#[IsDestructive]
#[Description(
    'Permanently delete a logged consumption. Find its id with list-consumptions. '
    .'The food item itself is kept. To fix a wrong amount, date or food, use update-consumption instead of deleting. '
    .'The response includes the deleted entry, so it can be re-logged with add-consumption if needed. Confirm with the user before deleting.'
)]
class DeleteConsumptionTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'consumption_id' => 'required|integer|min:1',
        ]);

        $consumption = Consumption::where('id', $validated['consumption_id'])
            ->where('user_id', $request->user()->id)
            ->with('food')
            ->first();

        if (! $consumption) {
            return Response::error("No consumption with id {$validated['consumption_id']} belongs to this user. Use list-consumptions to find it.");
        }

        $deleted = [
            'id' => $consumption->id,
            'consumed_at' => $consumption->consumed_at->toDateString(),
            'amount' => (float) $consumption->amount,
            'food' => [
                'id' => $consumption->food->id,
                'name' => $consumption->food->name,
            ],
            'calories' => $consumption->calories,
            'protein' => $consumption->protein,
        ];

        $consumption->delete();

        return Response::make(
            Response::text(sprintf(
                'Deleted consumption #%d: %s g/ml of "%s" (food #%d) on %s.',
                $deleted['id'],
                $deleted['amount'],
                $deleted['food']['name'],
                $deleted['food']['id'],
                $deleted['consumed_at'],
            ))
        )->withStructuredContent([
            'deleted' => true,
            'consumption' => $deleted,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'consumption_id' => $schema->integer()
                ->description('ID of the consumption to delete (from list-consumptions).')
                ->required(),
        ];
    }
}
