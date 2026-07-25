<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('categories');

        if ($request->filled('categoria')) {
            $slug = $request->get('categoria');
            $query->whereHas('categories', fn ($q) => $q->where('slug', $slug));
        }

        $products   = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('productos.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'reviews.user']);

        $averageRating = $product->reviews()->avg('rating');
        $canReview     = false;
        $alreadyReviewed = false;

        if (auth()->check()) {
            $alreadyReviewed = $product->reviews()->where('user_id', auth()->id())->exists();
            $canReview = !$alreadyReviewed;
        }

        return view('productos.show', compact('product', 'averageRating', 'canReview', 'alreadyReviewed'));
    }
}
