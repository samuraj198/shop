<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function __construct(private CategoryService $categoryService)
    {}

    public function store(array $data): Product
    {
        $product = Product::create($data);
        $this->categoryService->incrementCount($product->category_id);
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $oldCategoryId = $product->category_id;
        $newCategoryId = $data['category_id'];

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

        return $product->delete();
    }
}
