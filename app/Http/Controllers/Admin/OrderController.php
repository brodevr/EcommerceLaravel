<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.pedidos.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        return view('admin.pedidos.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        try {
            $order->changeStatus(OrderStatus::from($request->status));

            return redirect()->route('admin.pedidos.show', $order)
                             ->with('success', 'Estado actualizado correctamente.');
        } catch (\DomainException $e) {
            return redirect()->route('admin.pedidos.show', $order)
                             ->with('error', $e->getMessage());
        }
    }
}
