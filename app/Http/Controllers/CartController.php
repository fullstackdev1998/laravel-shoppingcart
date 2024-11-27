<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    protected CartService $cartService;

    // Inject CartService into the controller
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $cart = $this->cartService->getCart();

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty', 'cart' => []], Response::HTTP_OK);
        }

        $cartItems = collect($cart)->map(fn($item) => new CartResource($item));
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            'cart' => $cartItems,
            'total_price' => $total,
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $productId = $request->product_id;
        $cart = $this->cartService->addToCart($productId);

        if (!$cart) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Product added to cart', 'cart' => $cart], Response::HTTP_CREATED);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $cart = $this->cartService->removeFromCart($id);

        if (!$cart) {
            return response()->json(['error' => 'Product not found in cart'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Product removed from cart', 'cart' => $cart]);
    }
}

