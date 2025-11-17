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

    public function update(int $id, string $name): Category
    {
        $category = $this->repository->get($id);
        $category->update(['name' => $name]);

        return $category;
    }

    public function destroy(int $id): string
    {
        $check = $this->repository->destroy($id);
        if ($check) {
            return 'Вы успешно удалили категорию';
        }
        return 'Не удалось удалить категорию';
    }
}
