<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_store()
    {
        $user = User::create([
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        Auth::login($user);
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $category = Category::create([
            'name' => 'Test category for update',
            'img' => $uploadedFile,
        ]);
        $product = Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ]);
        $response = $this->post('/cart/' . $product->id);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response->assertRedirect();
    }

    public function test_cart_update()
    {
        $user = User::create([
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        Auth::login($user);
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $category = Category::create([
            'name' => 'Test category for update',
            'img' => $uploadedFile,
        ]);
        $product = Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ]);
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response = $this->put('/cart/' . $cartItem->id, [
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
        $response->assertRedirect();
    }

    public function test_cart_destroy()
    {
        $user = User::create([
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        Auth::login($user);
        $uploadedFile = UploadedFile::fake()->create('testImg.jpg');
        $category = Category::create([
            'name' => 'Test category for update',
            'img' => $uploadedFile,
        ]);
        $product = Product::create([
            'name' => 'Iphone X white',
            'img' => $uploadedFile,
            'description' => 'Smartphone Iphone X',
            'price' => 30000,
            'specifications' => [
                'color' => 'white',
                'memory' => '64GB',
                'model' => 'X'
            ],
            'category_id' => $category->id,
        ]);
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->delete('/cart/' . $cartItem->id);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response->assertRedirect();
    }
}
