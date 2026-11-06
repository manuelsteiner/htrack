<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\AddConsumptionTool;
use App\Mcp\Tools\AddFoodTool;
use App\Mcp\Tools\ConsumptionsSummaryTool;
use App\Mcp\Tools\DeleteConsumptionTool;
use App\Mcp\Tools\DeleteFoodTool;
use App\Mcp\Tools\ListConsumptionsTool;
use App\Mcp\Tools\ListFoodsTool;
use App\Mcp\Tools\UpdateConsumptionTool;
use App\Mcp\Tools\UpdateFoodTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('htrack')]
#[Version('1.2.0')]
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
    .'4. Fix mistakes with update-food (nutritional values; affects every consumption of that food) '
    .'or update-consumption (amount, date or food of one logged entry).
'
    .'5. Remove entries with delete-consumption, or delete-food for foods no consumption uses. '
    .'Deleting is permanent: prefer the update tools for corrections and confirm with the user first.

'
    .'Nutrient field names are fixed and the same in every tool: calories (kcal), carbohydrates, sugar, '
    .'fibre (British spelling, NOT "fiber"), fat, saturated_fat, protein (all g), sodium (mg, not salt). '
    .'Unknown fields are rejected.

'
    .'Dates are always YYYY-MM-DD. "today" filters use the user\'s configured timezone, not server time. '
    .'Amounts are always in grams or millilitres — never in serving counts.'
)]
class HtrackServer extends Server
{
    protected array $tools = [
        AddFoodTool::class,
        UpdateFoodTool::class,
        DeleteFoodTool::class,
        ListFoodsTool::class,
        AddConsumptionTool::class,
        UpdateConsumptionTool::class,
        DeleteConsumptionTool::class,
        ListConsumptionsTool::class,
        ConsumptionsSummaryTool::class,
    ];

    protected array $resources = [];

    protected array $prompts = [];
}
