<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;

class MainPageController extends Controller
{
    public function __construct(private ProductService $productService,
                                private CategoryService $categoryService)
    {}

    public function index()
    {
        $products = $this->productService->getForHomePage();
        $categories = $this->categoryService->getPopular();

        return view('welcome', compact('products', 'categories'));
    }
}
