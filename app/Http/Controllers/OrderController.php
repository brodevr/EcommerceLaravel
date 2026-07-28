<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
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
        $this->authorize('view', $order);

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

    public function store(StoreOrderRequest $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        /** @var User $user */
        $user = auth()->user();

        $address = $user->addresses()->find($request->integer('address_id'));

        if (! $address) {
            return back()->with('error', 'La dirección seleccionada no es válida.');
        }

        if (! $address->isComplete()) {
            $faltantes = implode(', ', $address->missingFields());

            return back()->with('error', "La dirección seleccionada está incompleta: falta {$faltantes}. Completala antes de confirmar el pedido.");
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id'             => $user->id,
            'shipping_address_id' => $address->id,
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
