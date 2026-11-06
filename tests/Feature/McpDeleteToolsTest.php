<?php

namespace Tests\Feature;

use App\Mcp\Servers\HtrackServer;
use App\Mcp\Tools\DeleteConsumptionTool;
use App\Mcp\Tools\DeleteFoodTool;
use App\Models\Consumption;
use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class McpDeleteToolsTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_unused_food(): void
    {
        $user = User::factory()->create();
        $food = $user->foods()->create(['name' => 'Oats', 'calories' => 370]);

        HtrackServer::actingAs($user)
            ->tool(DeleteFoodTool::class, ['food_id' => $food->id])
            ->assertOk()
            ->assertSee("Deleted food 'Oats'");

        $this->assertNull(Food::find($food->id));
    }

    public function test_delete_food_refuses_when_in_use(): void
    {
        $user = User::factory()->create();
        $food = $user->foods()->create(['name' => 'Oats', 'calories' => 370]);
        $user->consumptions()->create(['food_id' => $food->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs($user)
            ->tool(DeleteFoodTool::class, ['food_id' => $food->id])
            ->assertHasErrors(['used by 1 consumption']);

        $this->assertNotNull(Food::find($food->id));
    }

    public function test_delete_food_refuses_other_users_food(): void
    {
        $food = User::factory()->create()->foods()->create(['name' => 'Oats', 'calories' => 370]);

        HtrackServer::actingAs(User::factory()->create())
            ->tool(DeleteFoodTool::class, ['food_id' => $food->id])
            ->assertHasErrors();

        $this->assertNotNull(Food::find($food->id));
    }

    public function test_delete_consumption_keeps_food(): void
    {
        $user = User::factory()->create();
        $food = $user->foods()->create(['name' => 'Oats', 'calories' => 370]);
        $consumption = $user->consumptions()->create(['food_id' => $food->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs($user)
            ->tool(DeleteConsumptionTool::class, ['consumption_id' => $consumption->id])
            ->assertOk()
            ->assertSee('50 g/ml of "Oats"');

        $this->assertNull(Consumption::find($consumption->id));
        $this->assertNotNull(Food::find($food->id));
    }

    public function test_delete_consumption_refuses_other_users_entry(): void
    {
        $owner = User::factory()->create();
        $food = $owner->foods()->create(['name' => 'Oats', 'calories' => 370]);
        $consumption = $owner->consumptions()->create(['food_id' => $food->id, 'amount' => 50, 'consumed_at' => '2026-11-01']);

        HtrackServer::actingAs(User::factory()->create())
            ->tool(DeleteConsumptionTool::class, ['consumption_id' => $consumption->id])
            ->assertHasErrors();

        $this->assertNotNull(Consumption::find($consumption->id));
    }

    public function test_delete_tools_are_marked_destructive(): void
    {
        $this->assertTrue((new DeleteFoodTool)->toArray()['annotations']['destructiveHint']);
        $this->assertTrue((new DeleteConsumptionTool)->toArray()['annotations']['destructiveHint']);
    }
}
