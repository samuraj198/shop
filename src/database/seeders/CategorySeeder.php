<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CategorySeeder extends Seeder
{
    public function __construct(private CategoryService $categoryService)
    {}

    public function run(): void
    {
        if (!app()->environment('local', 'testing')) {
            $this->command->info('Сиды запускаются только в local/testing среде');
            return;
        }

        $categories = [
            ['id' => 1, 'name' => 'Смартфоны', 'img' => UploadedFile::fake()->create("Смартфоны.jpg")],
            ['id' => 2, 'name' => 'Компьютеры', 'img' => UploadedFile::fake()->create("Компьютеры.jpg")],
            ['id' => 3, 'name' => 'Мониторы', 'img' => UploadedFile::fake()->create("Мониторы.jpg")],
            ['id' => 4, 'name' => 'Ноутбуки', 'img' => UploadedFile::fake()->create("Ноутбуки.jpg")],
            ['id' => 5, 'name' => 'Клавиатуры', 'img' => UploadedFile::fake()->create("Клавиатуры.jpg")],
        ];
        foreach ($categories as $category) {
            if (!Category::where('name', $category['name'])->exists()) {
                $this->categoryService->store($category);
            }
        }
    }
}
