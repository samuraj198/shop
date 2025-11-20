<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function store(array $data): Category
    {
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            $imgName = $this->createNameForImage($data['img']);
            $data['img']->storeAs('categories', $imgName, 'public');
            $data['img'] = $imgName;
        }
        $category = Category::create($data);

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

        return $category;
    }

    public function destroy(Category $category): bool
    {
        Storage::disk('public')->delete('categories/' . $category->img);
        $category->delete();

        return true;
    }

    private function createNameForImage(UploadedFile $img): string
    {
        $name = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        return $name . '_' . time() . '.' . $img->getClientOriginalExtension();
    }
}
