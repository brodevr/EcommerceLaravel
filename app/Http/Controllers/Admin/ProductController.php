<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->paginate(20);

        return view('admin.productos.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.productos.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('img'), $data['image']);
        }

        $categoryIds = $data['categories'];
        unset($data['categories']);

        $product = Product::create($data);
        $product->categories()->sync($categoryIds);

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.productos.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('img'), $data['image']);
        }

        $categoryIds = $data['categories'];
        unset($data['categories']);

        $product->update($data);
        $product->categories()->sync($categoryIds);

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.productos.index')
                             ->with('error', "No se puede eliminar \"{$product->name}\" porque tiene pedidos asociados. Desactivalo en su lugar para ocultarlo del catálogo.");
        }

        $product->delete();

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return redirect()->route('admin.productos.index')
                         ->with('success', $product->is_active
                             ? "\"{$product->name}\" activado, ya es visible en el catálogo."
                             : "\"{$product->name}\" desactivado, ya no es visible en el catálogo.");
    }
}
