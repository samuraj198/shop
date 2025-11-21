<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category()
    {
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $data =  [
            'name' => 'Test category',
            'img' => $uploadedFile,
        ];
        $response = $this->post('/categories', $data);
        $category = Category::where('name', $data['name'])->first();

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
        ]);
        Storage::disk('public')->assertExists('categories/' . $category->img);

        $this->assertNotNull($category->img);
        $response->assertRedirect('/');

        Storage::disk('public')->delete('categories/' . $category->img);
    }

    public function test_update_category()
    {
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $category = Category::create([
            'name' => 'Test category for update',
            'img' => $uploadedFile,
        ]);
        $data = [
            'name' => 'update',
        ];
        $response = $this->put("/categories/$category->id", $data);
        $this->assertDatabaseHas('categories', $data);
        $response->assertRedirect('/');
        Storage::disk('public')->delete('categories/' . $category->img);
    }

    public function test_destroy_category()
    {
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $category = Category::create([
            'name' => 'Test category for delete',
            'img' => $uploadedFile,
        ]);
        $response = $this->delete("/categories/$category->id");
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $response->assertRedirect('/');
        Storage::disk('public')->delete('categories/' . $category->img);
    }
}
