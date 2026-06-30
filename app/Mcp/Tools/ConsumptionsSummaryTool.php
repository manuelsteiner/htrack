<?php

namespace App\Mcp\Tools;

use App\Models\Consumption;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Collection;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Name('consumptions-summary')]
#[IsReadOnly]
#[Description(
    'Aggregate nutritional totals over a date or date range, instead of returning individual consumption rows. '
    .'Filter modes (mutually exclusive): "today" (user\'s local today), "date" (single YYYY-MM-DD), or "from"+"to" (inclusive date range). '
    .'When "group_by_date" is true and a range is given, returns one row per date plus a grand total. '
    .'Otherwise returns a single combined total. All sums are kcal/grams/mg as appropriate.'
)]
class ConsumptionsSummaryTool extends Tool
{
    public function handle(Request $request): Response|ResponseFactory
    {
        $validated = $request->validate([
            'today' => 'nullable|boolean',
            'date' => 'nullable|date_format:Y-m-d',
            'from' => 'nullable|date_format:Y-m-d|required_with:to',
            'to' => 'nullable|date_format:Y-m-d|required_with:from|after_or_equal:from',
            'group_by_date' => 'nullable|boolean',
        ], [
            'date.date_format' => 'date must be in YYYY-MM-DD format.',
            'from.date_format' => 'from must be in YYYY-MM-DD format.',
            'to.date_format' => 'to must be in YYYY-MM-DD format.',
            'to.after_or_equal' => 'to must be the same as or after from.',
        ]);

        $user = $request->user();

        $today = $user->settings?->localised_date_string ?? now()->toDateString();
        $proteinTarget = $user->settings?->protein_target;

        $from = null;
        $to = null;
        $modeDescription = null;

        if (! empty($validated['today'])) {
            $from = $to = $today;
            $modeDescription = "today ({$today})";
        } elseif (! empty($validated['date'])) {
            $from = $to = $validated['date'];
            $modeDescription = "date {$validated['date']}";
        } elseif (! empty($validated['from']) && ! empty($validated['to'])) {
            $from = $validated['from'];
            $to = $validated['to'];
            $modeDescription = "{$from} through {$to}";
        } else {
            return Response::error('Provide one filter: today=true, date=YYYY-MM-DD, or from + to.');
        }

        $consumptions = Consumption::query()
            ->where('user_id', $user->id)
            ->whereDate('consumed_at', '>=', $from)
            ->whereDate('consumed_at', '<=', $to)
            ->with('food')
            ->get();

        $groupByDate = ! empty($validated['group_by_date']) && $from !== $to;

        $payload = [
            'mode' => $modeDescription,
            'from' => $from,
            'to' => $to,
            'protein_target' => $proteinTarget,
            'totals' => $this->totals($consumptions),
            'count' => $consumptions->count(),
        ];

        if ($groupByDate) {
            $byDate = [];
            $grouped = $consumptions->groupBy(fn (Consumption $c) => $c->consumed_at?->toDateString());

            foreach (CarbonPeriod::create($from, $to) as $day) {
                $key = $day->toDateString();
                $bucket = $grouped->get($key, collect());
                $byDate[] = [
                    'date' => $key,
                    'count' => $bucket->count(),
                    'totals' => $this->totals($bucket),
                ];
            }

            $payload['by_date'] = $byDate;
        }

        $totals = $payload['totals'];
        $text = sprintf(
            'Totals for %s: %d consumption(s), %s kcal, %sg carbs, %sg fat, %sg protein.',
            $modeDescription,
            $payload['count'],
            $this->fmt($totals['calories']),
            $this->fmt($totals['carbohydrates']),
            $this->fmt($totals['fat']),
            $this->fmt($totals['protein']),
        );

        if ($proteinTarget) {
            if ($from === $to) {
                $diff = round($totals['protein'] - $proteinTarget, 1);
                $text .= sprintf(
                    ' Protein floor %sg/day: %s.',
                    $this->fmt($proteinTarget),
                    $diff >= 0 ? $this->fmt($diff).'g over' : $this->fmt(abs($diff)).'g short',
                );
            } else {
                $text .= sprintf(' Protein floor %sg/day.', $this->fmt($proteinTarget));
            }
        }

        return Response::make(Response::text($text))->withStructuredContent($payload);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'today' => $schema->boolean()
                ->description('If true, summarise the user\'s local "today". Mutually exclusive with date/from/to.'),

            'date' => $schema->string()
                ->description('Single date in YYYY-MM-DD. Mutually exclusive with today/from/to.'),

            'from' => $schema->string()
                ->description('Inclusive range start in YYYY-MM-DD. Must be paired with "to".'),

            'to' => $schema->string()
                ->description('Inclusive range end in YYYY-MM-DD. Must be paired with "from" and ≥ from.'),

            'group_by_date' => $schema->boolean()
                ->description('Only meaningful with from+to. When true, also include per-date breakdown. Defaults to false.')
                ->default(false),
        ];
    }

    private function totals(Collection $consumptions): array
    {
        $sum = fn (string $field) => round($consumptions->sum(fn (Consumption $c) => $c->{$field} ?? 0), 1);

        return [
            'calories' => $sum('calories'),
            'carbohydrates' => $sum('carbohydrates'),
            'sugar' => $sum('sugar'),
            'fibre' => $sum('fibre'),
            'fat' => $sum('fat'),
            'saturated_fat' => $sum('saturated_fat'),
            'protein' => $sum('protein'),
            'sodium' => $sum('sodium'),
        ];
    }

    private function fmt($value): string
    {
        return rtrim(rtrim(number_format((float) $value, 1, '.', ''), '0'), '.');
    }
}
