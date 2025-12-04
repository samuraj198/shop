<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_product_by_name()
    {
        $phones = Category::create(['name' => 'Phones']);
        $laptops = Category::create(['name' => 'Laptops']);
        $uploadedFile = UploadedFile::fake()->create('testImg_2132131.jpg', 1024);
        Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $phones->id,
        ]);
        Product::create([
            'name' => 'laptop Lenovo',
            'img' => $uploadedFile,
            'description' => 'Laptop Lenovo',
            'price' => 20000,
            'specifications' => [
                'color' => 'white',
                'memory' => '256GB',
                'model' => 'GSX240'
            ],
            'category_id' => $laptops->id,
        ]);
        $response = $this->get('/catalog?name=iph');

        $count = Product::where('name', 'like', '%Iph%')->count();
        $this->assertEquals(1, $count);

        $response->assertOk();
    }

    public function test_search_product_by_category()
    {
        $phones = Category::create(['name' => 'Phones']);
        $laptops = Category::create(['name' => 'Laptops']);
        $uploadedFile = UploadedFile::fake()->create('testImg_2132131.jpg', 1024);
        Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $phones->id,
        ]);
        Product::create([
            'name' => 'laptop Lenovo',
            'img' => $uploadedFile,
            'description' => 'Laptop Lenovo',
            'price' => 20000,
            'specifications' => [
                'color' => 'white',
                'memory' => '256GB',
                'model' => 'GSX240'
            ],
            'category_id' => $laptops->id,
        ]);
        $response = $this->get('/catalog?category_id=' . $laptops->id);

        $count = Product::where('category_id', $laptops->id)->count();
        $this->assertEquals(1, $count);

        $response->assertOk();
    }
}
