<?php

namespace App\Mcp\Tools;

use App\Models\Food;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('add-food')]
#[Description(
    'Create a food item in the authenticated user\'s food database. '
    .'All nutritional values are expressed per 100 g (or 100 ml for liquids). '
    .'If a food with identical name and nutritional values already exists, '
    .'returns the existing food rather than creating a duplicate.'
)]
class AddFoodTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
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

        $user = $request->user();

        $existing = Food::where('user_id', $user->id)->where($validated)->first();

        if ($existing) {
            return Response::make(
                Response::text("A food item with these exact values already exists (id {$existing->id}). Returning the existing entry.")
            )->withStructuredContent([
                'created' => false,
                'food' => $this->foodToArray($existing),
            ]);
        }

        $food = $user->foods()->create($validated);

        return Response::make(
            Response::text("Created food '{$food->name}' (id {$food->id}).")
        )->withStructuredContent([
            'created' => true,
            'food' => $this->foodToArray($food),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('Display name of the food item, e.g. "Banana" or "Whole milk".')
                ->required(),

            'serving_size' => $schema->integer()
                ->description('Optional reference serving size in grams or millilitres (whole number, ≥ 1).'),

            'calories' => $schema->number()
                ->description('Energy in kcal per 100 g/ml. Optional but strongly recommended.'),

            'carbohydrates' => $schema->number()
                ->description('Carbohydrates in grams per 100 g/ml.'),

            'sugar' => $schema->number()
                ->description('Sugar in grams per 100 g/ml (subset of carbohydrates).'),

            'fibre' => $schema->number()
                ->description('Dietary fibre in grams per 100 g/ml.'),

            'fat' => $schema->number()
                ->description('Total fat in grams per 100 g/ml.'),

            'saturated_fat' => $schema->number()
                ->description('Saturated fat in grams per 100 g/ml (subset of fat).'),

            'protein' => $schema->number()
                ->description('Protein in grams per 100 g/ml.'),

            'sodium' => $schema->number()
                ->description('Sodium in milligrams per 100 g/ml.'),
        ];
    }

    private function foodToArray(Food $food): array
    {
        return [
            'id' => $food->id,
            'name' => $food->name,
            'serving_size' => $food->serving_size,
            'calories' => $food->calories,
            'carbohydrates' => $food->carbohydrates,
            'sugar' => $food->sugar,
            'fibre' => $food->fibre,
            'fat' => $food->fat,
            'saturated_fat' => $food->saturated_fat,
            'protein' => $food->protein,
            'sodium' => $food->sodium,
        ];
    }
}
