<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::where('is_active', true)
            ->with('categories:id,name,slug')
            ->paginate(15);

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        if (! $product->is_active) {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }

        $product->load('categories:id,name,slug', 'reviews.user:id,name');

        return response()->json($product);
    }
}
