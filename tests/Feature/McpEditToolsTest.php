<?php

namespace Tests\Feature;

use App\Mcp\Servers\HtrackServer;
use App\Mcp\Tools\AddFoodTool;
use App\Mcp\Tools\UpdateConsumptionTool;
use App\Mcp\Tools\UpdateFoodTool;
use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class McpEditToolsTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_food_maps_fiber_to_fibre(): void
    {
        $user = User::factory()->create();

        HtrackServer::actingAs($user)
            ->tool(AddFoodTool::class, ['name' => 'Bran', 'calories' => 300, 'fiber' => 40])
            ->assertOk()
            ->assertSee('"fiber" was stored as "fibre"');

        $this->assertEquals(40, Food::where('name', 'Bran')->first()->fibre);
    }

    public function test_add_food_rejects_unknown_fields(): void
    {
        $user = User::factory()->create();

        HtrackServer::actingAs($user)
            ->tool(AddFoodTool::class, ['name' => 'Bran', 'potassium' => 1])
            ->assertHasErrors(['Unknown field(s): potassium']);

        $this->assertSame(0, Food::count());
    }

    public function test_add_food_explains_salt_conversion(): void
    {
        $user = User::factory()->create();

        HtrackServer::actingAs($user)
            ->tool(AddFoodTool::class, ['name' => 'Bread', 'calories' => 250, 'salt' => 1.2])
            ->assertHasErrors(['salt_g × 400']);
    }

    public function test_update_food_changes_only_given_fields(): void
    {
        $user = User::factory()->create();
        $food = $user->foods()->create(['name' => 'Oats', 'calories' => 370, 'protein' => 13]);
        $user->consumptions()->create(['food_id' => $food->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs($user)
            ->tool(UpdateFoodTool::class, ['food_id' => $food->id, 'fiber' => 10])
            ->assertOk()
            ->assertSee(['fibre: null → 10', '1 logged consumption']);

        $food->refresh();
        $this->assertEquals(10, $food->fibre);
        $this->assertEquals(370, $food->calories);
    }

    public function test_update_food_can_clear_a_value(): void
    {
        $user = User::factory()->create();
        $food = $user->foods()->create(['name' => 'Oats', 'calories' => 370, 'sugar' => 1]);

        HtrackServer::actingAs($user)
            ->tool(UpdateFoodTool::class, ['food_id' => $food->id, 'sugar' => null])
            ->assertOk();

        $this->assertNull($food->fresh()->sugar);
    }

    public function test_update_food_refuses_other_users_food(): void
    {
        $food = User::factory()->create()->foods()->create(['name' => 'Oats', 'calories' => 370]);

        HtrackServer::actingAs(User::factory()->create())
            ->tool(UpdateFoodTool::class, ['food_id' => $food->id, 'name' => 'Mine'])
            ->assertHasErrors();

        $this->assertSame('Oats', $food->fresh()->name);
    }

    public function test_update_consumption(): void
    {
        $user = User::factory()->create();
        $oats = $user->foods()->create(['name' => 'Oats', 'calories' => 400]);
        $rice = $user->foods()->create(['name' => 'Rice', 'calories' => 130]);
        $consumption = $user->consumptions()->create(['food_id' => $oats->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs($user)
            ->tool(UpdateConsumptionTool::class, [
                'consumption_id' => $consumption->id,
                'amount' => 200,
                'food_id' => $rice->id,
            ])
            ->assertOk()
            ->assertSee('now 200 g/ml of "Rice" on 2026-11-01');

        $consumption->refresh();
        $this->assertEquals(200, $consumption->amount);
        $this->assertSame($rice->id, (int) $consumption->food_id);
    }

    public function test_update_consumption_refuses_other_users_entry(): void
    {
        $owner = User::factory()->create();
        $food = $owner->foods()->create(['name' => 'Oats', 'calories' => 370]);
        $consumption = $owner->consumptions()->create(['food_id' => $food->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs(User::factory()->create())
            ->tool(UpdateConsumptionTool::class, ['consumption_id' => $consumption->id, 'amount' => 1])
            ->assertHasErrors();

        $this->assertEquals(50, $consumption->fresh()->amount);
    }

    public function test_add_food_requires_calories(): void
    {
        HtrackServer::actingAs(User::factory()->create())
            ->tool(AddFoodTool::class, ['name' => 'Mystery'])
            ->assertHasErrors(['calories']);
    }

    public function test_update_food_rejects_duplicate(): void
    {
        $user = User::factory()->create();
        $user->foods()->create(['name' => 'Oats', 'calories' => 370]);
        $food = $user->foods()->create(['name' => 'Oatz', 'calories' => 370]);

        HtrackServer::actingAs($user)
            ->tool(UpdateFoodTool::class, ['food_id' => $food->id, 'name' => 'Oats'])
            ->assertHasErrors(['identical to food']);
    }

    public function test_food_tool_schemas_are_closed_and_spell_fibre(): void
    {
        $schema = (new UpdateFoodTool)->toArray()['inputSchema'];

        $this->assertFalse($schema['additionalProperties']);
        $this->assertArrayHasKey('fibre', $schema['properties']);
        $this->assertArrayNotHasKey('fiber', $schema['properties']);
    }
}
