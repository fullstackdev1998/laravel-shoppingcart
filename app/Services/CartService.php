<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    // Fetch all products from session cart
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return null;  // Product not found
        }

        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return $cart;
    }

    // Add a product to the cart

    public function getCart()
    {
        return session()->get('cart', []);
    }

    // Remove a product from the cart

    public function removeFromCart($productId)
    {
        $cart = $this->getCart();

        if (!isset($cart[$productId])) {
            return null;  // Product not in cart
        }

        unset($cart[$productId]);
        session()->put('cart', $cart);
        return $cart;
    }
}
