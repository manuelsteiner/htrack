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
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('list-foods')]
#[IsReadOnly]
#[Description(
    'List the authenticated user\'s food items, optionally filtered by name. '
    .'Use this to look up a food before adding a consumption (so you can pass its id). '
    .'Results are paginated; use the "page" argument to walk through more pages. '
    .'Nutritional values are per 100 g (or 100 ml for liquids).'
)]
class ListFoodsTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:name-asc,name-desc',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = $validated['per_page'] ?? 25;
        $page = $validated['page'] ?? 1;

        $user = $request->user();

        $paginator = Food::where('user_id', $user->id)
            ->filter(['search' => $validated['search'] ?? null])
            ->order(['sort' => $validated['sort'] ?? 'name-asc'])
            ->paginate(perPage: $perPage, page: $page);

        $foods = $paginator->getCollection()->map(fn (Food $food) => [
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
        ])->all();

        $header = sprintf(
            'Showing %d of %d foods (page %d of %d). Values per 100g/ml.',
            count($foods),
            $paginator->total(),
            $paginator->currentPage(),
            max(1, $paginator->lastPage()),
        );

        $lines = array_map(fn (array $food) => $this->formatLine($food), $foods);
        $text = $foods === [] ? $header : $header."\n".implode("\n", $lines);

        return Response::make(Response::text($text))->withStructuredContent([
            'foods' => $foods,
            'pagination' => [
                'page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ]);
    }

    private function formatLine(array $food): string
    {
        $serving = $food['serving_size'] !== null ? sprintf(' (serving %s)', $food['serving_size']) : '';

        return sprintf(
            '#%d %s%s — %s kcal, %sg carbs, %sg fat, %sg protein.',
            $food['id'],
            $food['name'],
            $serving,
            $this->fmt($food['calories']),
            $this->fmt($food['carbohydrates']),
            $this->fmt($food['fat']),
            $this->fmt($food['protein']),
        );
    }

    private function fmt($value): string
    {
        if ($value === null) {
            return 'NA';
        }

        return rtrim(rtrim(number_format((float) $value, 1, '.', ''), '0'), '.');
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'search' => $schema->string()
                ->description('Optional case-insensitive substring match against food names. Spaces are treated as wildcards (e.g. "whole milk" matches "Organic Whole Milk").'),

            'sort' => $schema->string()
                ->enum(['name-asc', 'name-desc'])
                ->description('Sort order by name. Defaults to name-asc.')
                ->default('name-asc'),

            'page' => $schema->integer()
                ->description('1-indexed page number. Defaults to 1.')
                ->default(1),

            'per_page' => $schema->integer()
                ->description('Items per page (1–100). Defaults to 25.')
                ->default(25),
        ];
    }
}
