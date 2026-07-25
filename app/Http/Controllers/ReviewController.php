<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Product $product)
    {
        $alreadyReviewed = $product->reviews()
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('review_error', 'Ya dejaste una reseña para este producto.');
        }

        $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating'  => $request->integer('rating'),
            'comment' => $request->input('comment'),
        ]);

        return back()->with('review_success', '¡Gracias por tu reseña!');
    }
}
