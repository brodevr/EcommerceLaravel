<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Portada del sitio: banner, beneficios y grid de productos.
     * Equivalente a home.php del PetShop original.
     */
    public function index()
    {
        $productos = Product::where('is_active', true)
            ->latest()
            ->paginate(6);

        return view('home', compact('productos'));
    }
}