<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogRequest;
use App\Services\CategoryService;
use App\Services\ProductService;

class CatalogController extends Controller
{
    public function __construct(private ProductService $productService,
                                private CategoryService $categoryService)
    {}

    public function index(CatalogRequest $request)
    {
        $products = $this->productService
            ->searchProducts($request->input('name'), $request->input('category_id'));

        $categories = $this->categoryService
            ->getCategories();

        return view('catalog', compact('products', 'categories'));
    }
}
