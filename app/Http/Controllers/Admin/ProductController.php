<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Lista todos los productos (vista admin).
     */
    public function index()
    {
        $products = Product::with('categories')->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
        // o en API: return response()->json($products);
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Guarda un nuevo producto.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Procesar imagen si viene
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Sincronizar categorías
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Procesar nueva imagen si viene
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Sincronizar categorías
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
}
