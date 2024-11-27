<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Http\Response;


it('can add a product to the cart', function () {
    // Create a product using the factory
    $product = Product::factory()->create();
    // Add product to the cart via the store endpoint
    $response = $this->postJson('/api/cart', [
        'product_id' => $product->id
    ]);

    // Assert the response status and message
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonFragment(['message' => 'Product added to cart']);

    // Ensure the cart session has the product added
    expect(session('cart'))->toHaveCount(1);
    expect(session('cart')[$product->id]['quantity'])->toBe(1);
});

it('can view the cart contents', function () {
    // Add a product to the cart
    $product = Product::factory()->create();
    $this->postJson('/api/cart', ['product_id' => $product->id]);

    // Fetch the cart contents
    $response = $this->getJson('/api/cart');

    // Assert the cart contains the product and the structure
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'cart' => [
                '*' => [
                    'name',
                    'price',
                    'quantity',
                ]
            ],
            'total_price',
        ]);
});

it('can remove a product from the cart', function () {
    // Add product to the cart
    $product = Product::factory()->create();
    $this->postJson('/api/cart', ['product_id' => $product->id]);

    // Remove the product from the cart
    $response = $this->deleteJson("/api/cart/{$product->id}");

    // Assert the response is successful and product is removed
    $response->assertStatus(Response::HTTP_NOT_FOUND);
    // Ensure the cart is now empty
    expect(session('cart'))->toBeEmpty();
});

it('returns an error when a product is not found while adding to the cart', function () {
    // Try to add a non-existent product (ID 999)
    $response = $this->postJson('/api/cart', ['product_id' => 999]);

    // Assert the response indicates product not found
    $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonFragment(['error' => 'Product not found']);
});

it('returns an error when a product is not found while removing from the cart', function () {
    // Try to remove a non-existent product (ID 999)
    $response = $this->deleteJson('/api/cart/999');

    // Assert the response indicates product not found in cart
    $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonFragment(['error' => 'Product not found in cart']);
});
