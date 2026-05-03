<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\AddConsumptionTool;
use App\Mcp\Tools\AddFoodTool;
use App\Mcp\Tools\ConsumptionsSummaryTool;
use App\Mcp\Tools\ListConsumptionsTool;
use App\Mcp\Tools\ListFoodsTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('htrack')]
#[Version('1.0.0')]
#[Instructions(
    'htrack is a personal food tracking app. Use these tools to manage the authenticated user\'s '
    .'food database and daily consumption log.

'
    .'Workflow:
'
    .'1. Find or create a food with list-foods / add-food. Foods carry nutritional values per 100 g/ml.
'
    .'2. Log a consumption with add-consumption (food_id + amount in g/ml + date).
'
    .'3. Inspect the log with list-consumptions (rows) or consumptions-summary (totals).

'
    .'Dates are always YYYY-MM-DD. "today" filters use the user\'s configured timezone, not server time. '
    .'Amounts are always in grams or millilitres — never in serving counts.'
)]
class HtrackServer extends Server
{
    protected array $tools = [
        AddFoodTool::class,
        ListFoodsTool::class,
        AddConsumptionTool::class,
        ListConsumptionsTool::class,
        ConsumptionsSummaryTool::class,
    ];

    protected array $resources = [];

    protected array $prompts = [];
}
