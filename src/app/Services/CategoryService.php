<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function __construct(private CacheService $cacheService)
    {}

    public function getCategories()
    {
        $categories = $this->cacheService->getCachedCategories();

        return $categories;
    }

    public function getPopular()
    {
        return Category::orderBy('count', 'desc')->limit(4);
    }

    public function store(array $data): Category
    {
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            $imgName = $this->createNameForImage($data['img']);
            $data['img']->storeAs('categories', $imgName, 'public');
            $data['img'] = $imgName;
        }
        $category = Category::create($data);
        $this->cacheService->clearCachedCategories();

        return $category;
    }

    public function update(Category $category, array $data): Category
    {
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            $imgName = $this->createNameForImage($data['img']);
            $data['img']->storeAs('categories', $imgName, 'public');
            $data['img'] = $imgName;
        }
        $category->update($data);
        $this->cacheService->clearCachedCategories();

        return $category;
    }

    public function destroy(Category $category): bool
    {
        Storage::disk('public')->delete('categories/' . $category->img);
        $category->delete();
        $this->cacheService->clearCachedCategories();

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

    public function createNameForImage(UploadedFile $img): string
    {
        $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        return $name . '_' . time() . '.' . $img->getClientOriginalExtension();
    }
}
