<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    private function getTableName(): string
    {
        return "recipes";
    }

    public function test_recipe_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/dashboard/recipe");

        $response->assertOk();
    }

    public function test_recipe_create_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/dashboard/recipe/create");

        $response->assertOk();
    }

    public function test_can_store_recipe(): void
    {
        $category = Category::create(['name' => 'New Category']);
        $ingredient = Ingredient::create(['name' => 'New Ingredient']);
        $data = [
            "name" => "Test Recipe",
            "category_id" => $category->id,
            "ingredients" => [
                [
                    "id" => $ingredient->id,
                    "amount" => "1 Bakul"
                ]
            ]
        ];

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post("/dashboard/recipe", $data);

        $this->assertDatabaseHas($this->getTableName(), [
            "name" => "Test Recipe",
            "category_id" => $category->id,
        ]);
    }

    public function test_recipe_edit_page_is_displayed(): void
    {
        $category = Category::create(['name' => 'New Category']);
        $data = [
            "name" => "Test Recipe",
            "category_id" => $category->id
        ];
        $recipe = Recipe::create($data);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/dashboard/recipe/{$recipe->id}/edit");

        $response->assertOk();
    }

    public function test_can_update_recipe(): void
    {
        $category = Category::create(['name' => 'New Category']);
        $ingredient = Ingredient::create(['name' => 'New Ingredient']);
        $data = [
            "name" => "Test Recipe",
            "category_id" => $category->id,
        ];

        $recipe = Recipe::create($data);
        $user = User::factory()->create();

        $new = [
            "name" => "Test Recipe Edit",
            "category_id" => $category->id,
            "ingredients" => [
                [
                    "id" => $ingredient->id,
                    "amount" => "1 Bakul"
                ]
            ]
        ];

        $this
            ->actingAs($user)
            ->put("/dashboard/recipe/{$recipe->id}", $new);

        $this->assertDatabaseHas($this->getTableName(), [
            "name" => "Test Recipe Edit",
            "category_id" => $category->id,
        ]);
    }

    public function test_can_delete_recipe(): void
    {
        $category = Category::create(['name' => 'New Category']);
        $data = [
            "name" => "Test Recipe",
            "category_id" => $category->id,
        ];

        $recipe = Recipe::create($data);
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->delete("/dashboard/recipe/{$recipe->id}");

        $this->assertDatabaseMissing($this->getTableName(), $data);
        $this->assertDatabaseEmpty($this->getTableName());
    }
}
