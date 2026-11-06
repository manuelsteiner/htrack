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

#[Name('add-food')]
#[Description(
    'Create a food item in the authenticated user\'s food database. '
    .'All nutritional values are expressed per 100 g (or 100 ml for liquids). '
    .'Field names are fixed: use "fibre" (British spelling) and "sodium" in mg; unknown fields are rejected. '
    .'If a food with identical name and nutritional values already exists, '
    .'returns the existing food rather than creating a duplicate. '
    .'To correct an existing food, use update-food instead.'
)]
class AddFoodTool extends Tool
{
    use HandlesFoodFields;

    public function handle(Request $request): Response|ResponseFactory
    {
        [$notes, $error] = $this->normaliseFoodArguments($request);

        if ($error !== null) {
            return Response::error($error);
        }

        $validated = $request->validate(
            ['name' => 'required|string|max:255'] + $this->foodFieldRules()
        );

        $user = $request->user();
        $noteText = $notes === [] ? '' : ' Note: '.implode('; ', $notes).'.';

        $existing = Food::where('user_id', $user->id)->where($validated)->first();

        if ($existing) {
            return Response::make(
                Response::text("A food item with these exact values already exists (id {$existing->id}). Returning the existing entry.".$noteText)
            )->withStructuredContent([
                'created' => false,
                'food' => $this->foodToArray($existing),
            ]);
        }

        $food = $user->foods()->create($validated);

        return Response::make(
            Response::text("Created food '{$food->name}' (id {$food->id}).".$noteText)
        )->withStructuredContent([
            'created' => true,
            'food' => $this->foodToArray($food),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        $fields = $this->foodFieldSchema($schema);

        $fields['name'] = $fields['name']->required();
        $fields['calories'] = $fields['calories']->required();

        return $fields;
    }
}
