<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user   = auth()->user();
        $orders = $user->orders()->latest()->paginate(10);

        return view('pedidos.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'shippingAddress']);

        return view('pedidos.show', compact('order'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        /** @var User $user */
        $user      = auth()->user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        $total     = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('checkout', compact('cart', 'addresses', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        /** @var User $user */
        $user  = auth()->user();
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id'             => $user->id,
            'shipping_address_id' => $request->filled('address_id') ? $request->integer('address_id') : null,
            'status'              => OrderStatus::Pendiente,
            'total'               => $total,
        ]);

        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', '¡Pedido realizado con éxito!');
    }
}
