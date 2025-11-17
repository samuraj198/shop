<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CategoryRepository $repository)
    {}

    public function store(array $data): Category
    {
        $category = $this->repository->store($data);

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
}
