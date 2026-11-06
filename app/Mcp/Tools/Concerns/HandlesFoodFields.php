<?php

namespace App\Mcp\Tools\Concerns;

use App\Models\Food;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;

/**
 * Shared argument handling for tools that write food nutrition values.
 *
 * Unknown keys are rejected rather than silently dropped, and common
 * alternative spellings (notably the American "fiber") are mapped to the
 * canonical column names, so a value can never vanish without a trace.
 */
trait HandlesFoodFields
{
    /**
     * Canonical writable food fields.
     */
    protected static array $foodFields = [
        'name', 'serving_size', 'calories', 'carbohydrates', 'sugar', 'fibre',
        'fat', 'saturated_fat', 'protein', 'sodium',
    ];

    /**
     * Accepted alternative spellings => canonical field.
     */
    protected static array $foodFieldAliases = [
        'fiber' => 'fibre',
        'dietary_fiber' => 'fibre',
        'dietary_fibre' => 'fibre',
        'carbs' => 'carbohydrates',
        'kcal' => 'calories',
        'energy' => 'calories',
        'sugars' => 'sugar',
        'saturated_fats' => 'saturated_fat',
        'saturates' => 'saturated_fat',
    ];

    /**
     * Rewrite aliased keys on the request and reject anything unknown.
     *
     * @param  string[]  $extraAllowed  Non-food keys the tool also accepts (e.g. food_id).
     * @return array{0: string[], 1: ?string} [notes about renamed keys, error message or null]
     */
    protected function normaliseFoodArguments(Request $request, array $extraAllowed = []): array
    {
        $arguments = $request->all();
        $allowed = array_merge(static::$foodFields, $extraAllowed);
        $notes = [];
        $unknown = [];

        foreach ($arguments as $key => $value) {
            if (in_array($key, $allowed, true)) {
                continue;
            }

            $canonical = static::$foodFieldAliases[strtolower($key)] ?? null;

            if ($canonical === null) {
                $unknown[] = $key;

                continue;
            }

            if (array_key_exists($canonical, $arguments) && $arguments[$canonical] != $value) {
                return [[], "Both \"{$key}\" and \"{$canonical}\" were given with different values. Send only \"{$canonical}\"."];
            }

            $arguments[$canonical] = $value;
            unset($arguments[$key]);
            $notes[] = "\"{$key}\" was stored as \"{$canonical}\"";
        }

        if (in_array('salt', $unknown, true)) {
            return [[], 'Unknown field "salt". This tool stores sodium in mg per 100 g/ml. Convert from salt in g: sodium_mg = salt_g × 400 (e.g. 1.2 g salt → 480 mg sodium), then send it as "sodium".'];
        }

        if ($unknown !== []) {
            return [[], sprintf(
                'Unknown field(s): %s. Accepted fields: %s. Note the British spelling "fibre".',
                implode(', ', $unknown),
                implode(', ', $allowed),
            )];
        }

        $request->setArguments($arguments);

        return [$notes, null];
    }

    /**
     * JSON schema entries for the nutrition fields (all optional).
     */
    protected function foodFieldSchema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('Display name of the food item, e.g. "Banana" or "Whole milk".'),

            'serving_size' => $schema->integer()
                ->description('Optional reference serving size in grams or millilitres (whole number, ≥ 1).'),

            'calories' => $schema->number()
                ->description('Energy in kcal per 100 g/ml. Cannot be null.'),

            'carbohydrates' => $schema->number()
                ->description('Carbohydrates in grams per 100 g/ml.'),

            'sugar' => $schema->number()
                ->description('Sugar in grams per 100 g/ml (subset of carbohydrates).'),

            'fibre' => $schema->number()
                ->description('Dietary fibre in grams per 100 g/ml. The key is spelled "fibre" (British spelling), not "fiber".'),

            'fat' => $schema->number()
                ->description('Total fat in grams per 100 g/ml.'),

            'saturated_fat' => $schema->number()
                ->description('Saturated fat in grams per 100 g/ml (subset of fat).'),

            'protein' => $schema->number()
                ->description('Protein in grams per 100 g/ml.'),

            'sodium' => $schema->number()
                ->description('Sodium in MILLIGRAMS per 100 g/ml. If a label only lists salt in grams, convert: sodium_mg = salt_g × 400.'),
        ];
    }

    /**
     * Validation rules for the nutrition fields.
     */
    protected function foodFieldRules(): array
    {
        return [
            'serving_size' => 'nullable|integer|min:1',
            'calories' => 'required|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
            'sugar' => 'nullable|numeric|min:0',
            'fibre' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'saturated_fat' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'sodium' => 'nullable|numeric|min:0',
        ];
    }

    protected function foodToArray(Food $food): array
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

    /**
     * Advertise that the input schema is closed, so clients don't invent keys.
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['inputSchema']['additionalProperties'] = false;

        return $array;
    }
}
