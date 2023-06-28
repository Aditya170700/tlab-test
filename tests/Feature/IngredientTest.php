<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    private function getTableName(): string
    {
        return "ingredients";
    }

    public function test_ingredient_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/dashboard/ingredient");

        $response->assertOk();
    }

    public function test_can_store_ingredient(): void
    {
        $user = User::factory()->create();
        $data = [
            "name" => "Test Ingredient",
        ];

        $this->actingAs($user)->post("/dashboard/ingredient", $data);

        $this->assertDatabaseHas($this->getTableName(), $data);
    }

    public function test_can_update_ingredient(): void
    {
        $user = User::factory()->create();

        $new = [
            "name" => "Test Ingredient",
        ];

        $ingredient = Ingredient::create($new);

        $this->assertDatabaseHas($this->getTableName(), $new);

        $data = [
            "name" => "Test Ingredient Edit",
        ];

        $this->actingAs($user)->put("/dashboard/ingredient/{$ingredient->id}", $data);

        $this->assertDatabaseHas($this->getTableName(), $data);
    }

    public function test_can_destroy_ingredient(): void
    {
        $user = User::factory()->create();

        $data = [
            "name" => "Test Ingredient",
        ];

        $ingredient = Ingredient::create($data);

        $this->assertDatabaseHas($this->getTableName(), $data);

        $this->actingAs($user)->delete("/dashboard/ingredient/{$ingredient->id}");

        $this->assertDatabaseMissing($this->getTableName(), $data);
        $this->assertDatabaseEmpty($this->getTableName());
    }
}
