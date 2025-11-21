<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {}

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->productService->store($data);

        return redirect('/')->with('success', 'Товар успешно добавлен');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = $this->productService->update($product, $data);

        return redirect('/')->with('success', 'Вы успешно изменили товар');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($this->productService->destroy($product)) {
            return redirect('/')->with('success', 'Вы успешно удалили товар');
        }
        return redirect()->back()->withErrors(['Не удалось удалить товар']);
    }
}
