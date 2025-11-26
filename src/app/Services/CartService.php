<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

class CartService
{
    public function getCartItems(): Collection
    {
        return CartItem::where('user_id', Auth::id())->with('product')->get();
    }

    public function getTotalPrice(): int
    {
        $cartItems = $this->getCartItems();
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }
        return $totalPrice;
    }

    public function store(Product $product): CartItem
    {
        return CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);
    }

    public function update(CartItem $cartItem, int $quantity): CartItem
    {
        $cartItem->update(['quantity' => $quantity]);

        return $cartItem;
    }

    public function destroy(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }
}
