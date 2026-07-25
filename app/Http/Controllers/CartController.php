<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('carrito.index', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        $cart = session('cart', []);
        $id   = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name'     => $product->name,
                'price'    => (float) $product->price,
                'image'    => $product->image,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('cart_success', "«{$product->name}» agregado al carrito.");
    }

    public function update(Request $request, Product $product)
    {
        $cart = session('cart', []);
        $qty  = max(0, (int) $request->input('quantity', 1));

        if ($qty === 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id]['quantity'] = $qty;
        }

        session(['cart' => $cart]);

        return back()->with('cart_success', 'Carrito actualizado.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('cart_success', 'Producto quitado del carrito.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('cart_success', 'Carrito vaciado.');
    }
}
