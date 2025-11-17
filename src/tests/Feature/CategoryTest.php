<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category()
    {
        $data =  [
            'name' => 'Test category',
        ];
        $response = $this->post('/categories', $data);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_update_category()
    {
        $category = Category::create([
            'name' => 'Test category for update',
        ]);
        $data = [
            'name' => 'update',
        ];
        $response = $this->put("/categories/$category->id", $data);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_destroy_category()
    {
        $category = Category::create([
            'name' => 'Test category for delete',
        ]);
        $response = $this->delete("/categories/$category->id");
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
