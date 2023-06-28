<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private function getTableName(): string
    {
        return 'categories';
    }

    public function test_category_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard/category');

        $response->assertOk();
    }

    public function test_can_store_category(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Category',
        ];

        $this->actingAs($user)->post('/dashboard/category', $data);

        $this->assertDatabaseHas($this->getTableName(), $data);
    }

    public function test_can_update_category(): void
    {
        $user = User::factory()->create();

        $new = [
            'name' => 'Test Category',
        ];

        $category = Category::create($new);

        $this->assertDatabaseHas($this->getTableName(), $new);

        $data = [
            'name' => 'Test Category Edit',
        ];

        $this->actingAs($user)->put("/dashboard/category/{$category->id}", $data);

        $this->assertDatabaseHas($this->getTableName(), $data);
    }

    public function test_can_destroy_category(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test Category',
        ];

        $category = Category::create($data);

        $this->assertDatabaseHas($this->getTableName(), $data);

        $this->actingAs($user)->delete("/dashboard/category/{$category->id}");

        $this->assertDatabaseMissing($this->getTableName(), $data);
        $this->assertDatabaseEmpty($this->getTableName());
    }
}
