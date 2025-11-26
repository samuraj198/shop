<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {}

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        $totalPrice = $this->cartService->getTotalPrice();

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function store(Product $product)
    {
        $cartItem = $this->cartService->store($product);

        return redirect()->back()->with('success', 'Вы успешно добавили товар в корзину');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->cartService->update($cartItem, $request['quantity']);

        return redirect()->back()->with('success', 'Вы успешно изменили количество товара в корзине');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($this->cartService->destroy($cartItem)) {
            return redirect()->back()->with('success', 'Вы успешно удалили товар из корзины');
        }
        return redirect()->back()->withErrors(['Что-то пошло не так']);
    }
}
