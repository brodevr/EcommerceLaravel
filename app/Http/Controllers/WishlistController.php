<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Muestra la lista de deseos del usuario autenticado.
     */
    public function index()
    {
        $wishlist = auth()->user()
            ->wishlist() // relación belongsToMany
            ->with('categories') // opcional: cargar categorías de cada producto
            ->get();

        return response()->json($wishlist);
    }

    /**
     * Agrega un producto a la lista de deseos.
     * Evita duplicados con syncWithoutDetaching.
     */
    public function store(Product $product)
    {
        auth()->user()
            ->wishlist()
            ->syncWithoutDetaching([$product->id]);

        return response()->json([
            'message' => 'Producto agregado a la lista de deseos.',
            'product' => $product,
        ]);
    }

    /**
     * Elimina un producto de la lista de deseos.
     */
    public function destroy(Product $product)
    {
        auth()->user()
            ->wishlist()
            ->detach($product->id);

        return response()->json([
            'message' => 'Producto eliminado de la lista de deseos.',
            'product' => $product,
        ]);
    }
}
