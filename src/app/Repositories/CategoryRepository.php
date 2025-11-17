<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\Repository;

class CategoryRepository implements Repository
{
    public function store(array $data): Category
    {
        $category = Category::create($data);

        return $category;
    }
}
