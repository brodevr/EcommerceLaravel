<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Lista todos los pedidos.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
        // En API: return response()->json($orders);
    }

    /**
     * Muestra el detalle de un pedido.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', compact('order'));
        // En API: return response()->json($order);
    }

    /**
     * Actualiza el estado de un pedido.
     * Usa la capa de negocio (changeStatus) para validar transiciones.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        try {
            $order->changeStatus(OrderStatus::from($request->status));

            return redirect()->route('admin.orders.show', $order)
                             ->with('success', 'Estado actualizado correctamente.');
        } catch (\DomainException $e) {
            // Captura la excepción de transición inválida
            return redirect()->route('admin.orders.show', $order)
                             ->with('error', $e->getMessage());
        }
    }
}