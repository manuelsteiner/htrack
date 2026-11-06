<?php

namespace Tests\Feature;

use App\Models\Consumption;
use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditFoodAndConsumptionTest extends TestCase
{
    use RefreshDatabase;

    private function food(User $user, array $attributes = []): Food
    {
        return $user->foods()->create($attributes + [
            'name' => 'Oats',
            'calories' => 370,
            'carbohydrates' => 60,
            'fibre' => 10,
            'fat' => 7,
            'protein' => 13,
        ]);
    }

    private function consumption(User $user, Food $food, array $attributes = []): Consumption
    {
        return $user->consumptions()->create($attributes + [
            'food_id' => $food->id,
            'amount' => 80,
            'consumed_at' => '2026-11-01',
        ]);
    }

    public function test_food_edit_page_is_prefilled(): void
    {
        $user = User::factory()->create();
        $food = $this->food($user);
        $this->consumption($user, $food);

        $this->actingAs($user)
            ->get(route('foods.edit', $food))
            ->assertOk()
            ->assertSee('Edit food item')
            ->assertSee('value="Oats"', false)
            ->assertSee('value="10"', false)
            ->assertSee('Used in 1 consumption.', false);
    }

    public function test_food_can_be_updated(): void
    {
        $user = User::factory()->create();
        $food = $this->food($user);

        $this->actingAs($user)
            ->put(route('foods.update', $food), [
                'name' => 'Rolled oats',
                'calories' => 372,
                'fibre' => 9.5,
                'protein' => 13.5,
                'fat' => '', // the form always submits every field; blank clears it
            ])
            ->assertRedirect(route('foods.show', $food));

        $food->refresh();
        $this->assertSame('Rolled oats', $food->name);
        $this->assertEquals(9.5, $food->fibre);
        $this->assertNull($food->fat);
    }

    public function test_food_update_validates(): void
    {
        $user = User::factory()->create();
        $food = $this->food($user);

        $this->actingAs($user)
            ->put(route('foods.update', $food), ['name' => '', 'calories' => -1])
            ->assertSessionHasErrors(['name', 'calories']);
    }

    public function test_food_update_rejects_duplicate(): void
    {
        $user = User::factory()->create();
        $this->food($user, ['name' => 'Rice', 'calories' => 130, 'carbohydrates' => null, 'fibre' => null, 'fat' => null, 'protein' => null]);
        $food = $this->food($user);

        $this->actingAs($user)
            ->from(route('foods.edit', $food))
            ->put(route('foods.update', $food), ['name' => 'Rice', 'calories' => 130])
            ->assertRedirect(route('foods.edit', $food))
            ->assertSessionHas('danger');

        $this->assertSame('Oats', $food->fresh()->name);
    }

    public function test_cannot_edit_another_users_food(): void
    {
        $owner = User::factory()->create();
        $food = $this->food($owner);

        $this->actingAs(User::factory()->create())
            ->put(route('foods.update', $food), ['name' => 'Hacked'])
            ->assertForbidden();

        $this->assertSame('Oats', $food->fresh()->name);
    }

    public function test_consumption_edit_page_preselects_food(): void
    {
        $user = User::factory()->create();
        $food = $this->food($user);
        $consumption = $this->consumption($user, $food);

        $this->actingAs($user)
            ->get(route('consumptions.edit', $consumption))
            ->assertOk()
            ->assertSee('Edit consumption')
            ->assertSee('id="ht-initial-food"', false)
            ->assertSee('value="2026-11-01"', false)
            ->assertSee('value="80"', false);
    }

    public function test_consumption_can_be_updated(): void
    {
        $user = User::factory()->create();
        $oats = $this->food($user);
        $rice = $this->food($user, ['name' => 'Rice']);
        $consumption = $this->consumption($user, $oats);

        $this->actingAs($user)
            ->put(route('consumptions.update', $consumption), [
                'food_id' => $rice->id,
                'amount' => 120,
                'consumed_at' => '2026-11-02',
            ])
            ->assertRedirect(route('consumptions.show', $consumption));

        $consumption->refresh();
        $this->assertSame($rice->id, (int) $consumption->food_id);
        $this->assertEquals(120, $consumption->amount);
        $this->assertSame('2026-11-02', $consumption->consumed_at->toDateString());
    }

    public function test_consumption_update_rejects_missing_food(): void
    {
        $user = User::factory()->create();
        $consumption = $this->consumption($user, $this->food($user));

        $this->actingAs($user)
            ->put(route('consumptions.update', $consumption), [
                'food_id' => 9999,
                'amount' => 120,
                'consumed_at' => '2026-11-02',
            ])
            ->assertSessionHasErrors('food_id');
    }

    public function test_cannot_edit_another_users_consumption(): void
    {
        $owner = User::factory()->create();
        $consumption = $this->consumption($owner, $this->food($owner));

        $this->actingAs(User::factory()->create())
            ->get(route('consumptions.edit', $consumption))
            ->assertForbidden();
    }
}
