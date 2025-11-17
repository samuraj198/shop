<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\Repository;
use function Sodium\increment;

class CategoryRepository implements Repository
{
    public function store(array $data): Category
    {
        $category = Category::create($data);

        return $category;
    }

    public function get(int $id): Category
    {
        $category = Category::findOrFail($id);

        return $category;
    }

    public function destroy(int $id): bool
    {
        if (Category::destroy($id)) {
            return true;
        }
        return false;
    }
}
