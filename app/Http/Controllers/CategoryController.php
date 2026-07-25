<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $products    = $category->products()->with('categories')->paginate(12);
        $categories  = Category::orderBy('name')->get();
        $activeSlug  = $category->slug;

        return view('productos.index', compact('products', 'categories', 'activeSlug'));
    }
}
