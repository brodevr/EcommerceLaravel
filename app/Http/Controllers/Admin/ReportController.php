<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Ventas totales (pedidos que implican cobro real)
        $ventasTotales = Order::whereIn('status', [
            OrderStatus::Procesando->value,
            OrderStatus::Enviado->value,
            OrderStatus::Entregado->value,
        ])->sum('total');

        // 2. Pedidos por estado
        $pedidosPorEstado = collect(OrderStatus::cases())
            ->mapWithKeys(fn($status) => [
                $status->value => Order::where('status', $status->value)->count(),
            ]);

        $totalPedidos = $pedidosPorEstado->sum();

        // 3. Top 5 productos más vendidos (agrupado en PHP con colecciones)
        $topProductos = OrderItem::with('product')
            ->get()
            ->groupBy('product_id')
            ->map(fn($items) => (object) [
                'product'       => $items->first()->product,
                'total_vendido' => $items->sum('quantity'),
            ])
            ->sortByDesc('total_vendido')
            ->take(5)
            ->values();

        // 4. Usuarios registrados
        $totalUsuarios  = User::count();
        $nuevosUsuarios = User::where('created_at', '>=', now()->subDays(30))->count();

        // 5. Productos con stock bajo (activos con stock < 5)
        $stockBajo = Product::where('stock', '<', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->get();

        return view('admin.reportes.index', compact(
            'ventasTotales',
            'pedidosPorEstado',
            'totalPedidos',
            'topProductos',
            'totalUsuarios',
            'nuevosUsuarios',
            'stockBajo',
        ));
    }
}
