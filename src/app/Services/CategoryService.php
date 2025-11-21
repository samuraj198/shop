<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store(array $data): Category
    {
        $category = Category::create($data);

        return $category;
    }

    public function update(Category $category, string $name): Category
    {
        $category->update(['name' => $name]);

        return $category;
    }

    public function destroy(Category $category): bool
    {
        $category->delete();

        return true;
    }

    public function incrementCount(int $id): void
    {
        Category::where('id', $id)->increment('count');
    }

    public function decrementCount(int $id): void
    {
        Category::where('id', $id)->decrement('count');
    }
}
