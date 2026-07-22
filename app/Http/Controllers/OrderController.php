<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Lista los pedidos del usuario autenticado.
     */
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->latest()
            ->get();

        return response()->json($orders);
    }

    /**
     * Muestra el detalle de un pedido específico.
     * Se aplica la Policy para asegurar que el usuario solo vea sus propios pedidos.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order); // Usa OrderPolicy

        $order->load(['items.product', 'user']); 
        // 'items.product' asume que tienes una relación Order->items->product

        return response()->json($order);
    }
}
