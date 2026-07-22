<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Muestra los productos pertenecientes a una categoría.
     */
    public function show(Category $category): View
    {
        $products = $category
            ->products()
            ->paginate(6);

        return view('categories.show', compact('category', 'products'));
    }
}