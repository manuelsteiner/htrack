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
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('list-consumptions')]
#[IsReadOnly]
#[Description(
    'List the authenticated user\'s consumptions, optionally filtered by date. '
    .'Filter modes (mutually exclusive): "today" (user\'s local today), "date" (single YYYY-MM-DD), or "from"+"to" (inclusive date range). '
    .'If no date filter is provided, returns the most recent consumptions across all dates. '
    .'Use the consumptions-summary tool when you need totals rather than individual rows.'
)]
class ListConsumptionsTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'today' => 'nullable|boolean',
            'date' => 'nullable|date_format:Y-m-d',
            'from' => 'nullable|date_format:Y-m-d|required_with:to',
            'to' => 'nullable|date_format:Y-m-d|required_with:from|after_or_equal:from',
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:date-asc,date-desc',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ], [
            'date.date_format' => 'date must be in YYYY-MM-DD format.',
            'from.date_format' => 'from must be in YYYY-MM-DD format.',
            'to.date_format' => 'to must be in YYYY-MM-DD format.',
            'to.after_or_equal' => 'to must be the same as or after from.',
        ]);

        $user = $request->user();

        $query = Consumption::query()
            ->where('user_id', $user->id)
            ->with('food');

        if (! empty($validated['today'])) {
            $today = $user->settings?->localised_date_string ?? now()->toDateString();
            $query->whereDate('consumed_at', $today);
        } elseif (! empty($validated['date'])) {
            $query->whereDate('consumed_at', $validated['date']);
        } elseif (! empty($validated['from']) && ! empty($validated['to'])) {
            $query->whereDate('consumed_at', '>=', $validated['from'])
                ->whereDate('consumed_at', '<=', $validated['to']);
        }

        $query->order(['sort' => $validated['sort'] ?? 'date-desc']);

        if (! empty($validated['search'])) {
            $query->whereHas('food', function ($q) use ($validated) {
                $q->where('name', 'LIKE', '%'.str_replace(' ', '%', trim($validated['search'])).'%');
            });
        }

        $perPage = $validated['per_page'] ?? 50;
        $page = $validated['page'] ?? 1;

        $paginator = $query->paginate(perPage: $perPage, page: $page);

        $rows = $paginator->getCollection()->map(fn (Consumption $c) => [
            'id' => $c->id,
            'consumed_at' => $c->consumed_at?->toDateString(),
            'amount' => (float) $c->amount,
            'food' => [
                'id' => $c->food?->id,
                'name' => $c->food?->name,
            ],
            'calories' => $c->calories,
            'carbohydrates' => $c->carbohydrates,
            'sugar' => $c->sugar,
            'fibre' => $c->fibre,
            'fat' => $c->fat,
            'saturated_fat' => $c->saturated_fat,
            'protein' => $c->protein,
            'sodium' => $c->sodium,
        ])->all();

        $summary = sprintf(
            'Showing %d of %d consumptions (page %d of %d).',
            count($rows),
            $paginator->total(),
            $paginator->currentPage(),
            max(1, $paginator->lastPage()),
        );

        return Response::make(Response::text($summary))->withStructuredContent([
            'consumptions' => $rows,
            'pagination' => [
                'page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'today' => $schema->boolean()
                ->description('If true, restrict to the user\'s local "today". Mutually exclusive with date/from/to.'),

            'date' => $schema->string()
                ->description('Single date filter in YYYY-MM-DD. Mutually exclusive with today/from/to.'),

            'from' => $schema->string()
                ->description('Start of inclusive date range, YYYY-MM-DD. Must be paired with "to".'),

            'to' => $schema->string()
                ->description('End of inclusive date range, YYYY-MM-DD. Must be paired with "from" and ≥ from.'),

            'search' => $schema->string()
                ->description('Optional substring match against the consumed food\'s name (spaces act as wildcards).'),

            'sort' => $schema->string()
                ->enum(['date-asc', 'date-desc'])
                ->description('Sort by consumed_at ascending or descending. Defaults to date-desc.')
                ->default('date-desc'),

            'page' => $schema->integer()
                ->description('1-indexed page number. Defaults to 1.')
                ->default(1),

            'per_page' => $schema->integer()
                ->description('Items per page (1–100). Defaults to 50.')
                ->default(50),
        ];
    }
}
