<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class ProductSeeder extends Seeder
{
    public function __construct(private ProductService $productService)
    {}

    public function run(): void
    {
        if (!app()->environment('local', 'testing')) {
            $this->command->info('Сиды запускаются только в local/testing среде');
            return;
        }
        $products = [
            [
                'id' => 1,
                'name' => "Iphone X белый",
                'description' => "Белый айфон 10 на 64 гб",
                'price' => 40000,
                'specifications' => ['memory' => '64GB'],
                'category_id' => 1,
                'img' => UploadedFile::fake()->create("IphoneX.jpg"),
            ],
            [
                'id' => 2,
                'name' => "Ardor Gaming Guardian Keyboard",
                'description' => "Механическая клавиатура ardor gaming",
                'price' => 8000,
                'specifications' => ['type' => 'Механическая'],
                'category_id' => 5,
                'img' => UploadedFile::fake()->create("ArdorGamingGuardian.jpg"),
            ],
        ];
        foreach ($products as $product) {
            if (!Product::where('name', $product['name'])->exists()) {
                $this->productService->store($product);
            }
        }
    }
}
