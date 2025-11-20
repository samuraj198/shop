<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_product()
    {
        $category = Category::create(['name' => 'Phones']);

        $uploadedFile = UploadedFile::fake()->create('testImg.jpg', 1024);
        $data = [
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ];
        $response = $this->post('/products', $data);
        $product = Product::where('name', $data['name'])->first();

        $this->assertDatabaseHas('products', [
            'name' => 'Iphone X white',
            'category_id' => $category->id,
        ]);
        $this->assertEquals(1, $category->fresh()->count);
        Storage::disk('public')->assertExists('products/' . $product->img);
        $this->assertNotNull($product->img);
        $response->assertRedirect('/');

        Storage::disk('public')->delete('products/' . $uploadedFile);
    }

    public function test_update_product()
    {
        $category = Category::create(['name' => 'Phones']);
        $uploadedFile = UploadedFile::fake()->create('testImg_2132131.jpg', 1024);
        $product = Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ]);

        $data = [
            'name' => 'Iphone X black',
            'description' => 'Smartphone Iphone X with black color',
            'price' => 35000,
            'discount' => 10,
            'specifications' => [
                'color' => 'black',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ];
        $response = $this->put('/products/' . $product->id, $data);

        $this->assertDatabaseHas('products', [
            'name' => 'Iphone X black',
            'description' => 'Smartphone Iphone X with black color',
            'price' => 35000,
            'discount' => 10,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect('/');
        Storage::disk('public')->delete('products/' . $uploadedFile);
    }

    public function test_delete_product()
    {
        $category = Category::create(['name' => 'Phones']);
        $uploadedFile = UploadedFile::fake()->create('testImg_2132131.jpg', 1024);
        $product = Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ]);
        $category->increment('count');
        $response = $this->delete('/products/' . $product->id);
        $this->assertDatabaseMissing('products', [
            'name' => 'Iphone X white',
            'category_id' => $category->id,
        ]);
        $this->assertEquals(0, $category->fresh()->count);
        $response->assertRedirect('/');

        Storage::disk('public')->delete('products/' . $uploadedFile);
    }
}
