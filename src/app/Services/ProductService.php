<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(private CategoryService $categoryService)
    {}

    public function store(array $data): Product
    {
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            $imgName = $this->createNameForImage($data['img']);
            $data['img']->storeAs('products', $imgName, 'public');
            $data['img'] = $imgName;
        }
        $product = Product::create($data);
        $this->categoryService->incrementCount($product->category_id);
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $oldCategoryId = $product->category_id;
        $newCategoryId = $data['category_id'];

        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            Storage::disk('public')->delete('products/' . $product->img);
            $imgName = $this->createNameForImage($data['img']);
            $data['img']->storeAs('products', $imgName, 'public');
            $data['img'] = $imgName;
        }

        if ($oldCategoryId != $newCategoryId) {
            $this->categoryService->decrementCount($oldCategoryId);
            $this->categoryService->incrementCount($newCategoryId);
        }
        $product->update($data);
        return $product;
    }

    public function destroy(Product $product): bool
    {
        $this->categoryService->decrementCount($product->category_id);
        Storage::disk('public')->delete('products/' . $product->img);

        return $product->delete();
    }

    private function createNameForImage($img): string
    {
        $name = $img->getClientOriginalName();
        return $name . '_' . time() . '.' . $img->getClientOriginalExtension();
    }
}
