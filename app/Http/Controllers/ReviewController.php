<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    /**
     * Crea una reseña para un producto.
     * Aplica la ReviewPolicy antes de permitir la acción.
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
        // Policy: asegura que el usuario pueda crear reseñas
        $this->authorize('create', [Review::class, $product]);

        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating'  => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'message' => 'Reseña creada correctamente.',
            'review'  => $review->load('user'),
        ], 201);
    }
}
