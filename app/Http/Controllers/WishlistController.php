<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class WishlistController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user     = auth()->user();
        $productos = $user->wishlist()->get();

        return view('wishlist.index', compact('productos'));
    }

    public function store(Product $product)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->wishlist()->syncWithoutDetaching([$product->id]);

        return back()->with('success', 'Producto agregado a tu wishlist.');
    }

    public function destroy(Product $product)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->wishlist()->detach($product->id);

        return back()->with('success', 'Producto quitado de tu wishlist.');
    }
}
