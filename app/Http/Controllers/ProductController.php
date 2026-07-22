<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra el catálogo de productos.
     * Si se pasa ?categoria=slug, filtra por esa categoría.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('categories');

        // Filtrar por categoría si viene el parámetro
        if ($request->has('categoria')) {
            $slug = $request->get('categoria');
            $query->whereHas('categories', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Paginado (ejemplo: 12 por página)
        $products = $query->paginate(12);

        return response()->json($products);
    }

    /**
     * Muestra el detalle de un producto.
     * Aprovecha Route Model Binding.
     */
    public function show(Product $product)
    {
        // Cargar relaciones necesarias
        $product->load(['categories', 'reviews.user']);

        // Calcular promedio de reviews
        $averageRating = $product->averageRating();

        return response()->json([
            'product' => $product,
            'average_rating' => $averageRating,
        ]);
    }
}
