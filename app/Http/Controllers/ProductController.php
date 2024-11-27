<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke()
    {
        return ProductResource::collection(Product::all());
    }
}
