@extends('layouts.admin')
@section('title', 'Reportes')

@section('content')
<h1 class="text-2xl font-bold text-petfy-dark mb-6">Reportes</h1>

{{-- ── 4 cards de resumen ────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Ventas totales</p>
        <p class="text-2xl font-bold text-petfy-dark">
            ${{ number_format((float) $ventasTotales, 2, ',', '.') }}
        </p>
        <p class="text-xs text-slate-400 mt-1">Procesando + Enviado + Entregado</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Total pedidos</p>
        <p class="text-2xl font-bold text-petfy-dark">{{ $totalPedidos }}</p>
        <p class="text-xs text-slate-400 mt-1">Todos los estados</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Usuarios</p>
        <p class="text-2xl font-bold text-petfy-dark">{{ $totalUsuarios }}</p>
        <p class="text-xs text-slate-400 mt-1">
            <span class="text-green-600 font-semibold">+{{ $nuevosUsuarios }}</span> últimos 30 días
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Stock bajo</p>
        <p class="text-2xl font-bold {{ $stockBajo->count() > 0 ? 'text-amber-500' : 'text-petfy-dark' }}">
            {{ $stockBajo->count() }}
        </p>
        <p class="text-xs text-slate-400 mt-1">Productos activos con stock &lt; 5</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- ── Pedidos por estado ──────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-base font-semibold text-petfy-dark mb-4">Pedidos por estado</h2>

        @forelse(\App\Enums\OrderStatus::cases() as $status)
            @php
                $count  = $pedidosPorEstado[$status->value] ?? 0;
                $pct    = $totalPedidos > 0 ? round($count / $totalPedidos * 100) : 0;
            @endphp
            <div class="mb-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="inline-flex items-center gap-1.5">
                        <x-status-badge :status="$status" />
                    </span>
                    <span class="text-sm font-semibold text-slate-700">{{ $count }}</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-petfy rounded-full transition-all duration-500"
                         style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400">Sin pedidos registrados.</p>
        @endforelse
    </div>

    {{-- ── Top 5 productos ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-base font-semibold text-petfy-dark mb-4">Top 5 productos más vendidos</h2>

        @if($topProductos->isEmpty())
            <p class="text-sm text-slate-400">Sin ventas registradas todavía.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-slate-400 border-b border-slate-100">
                        <th class="text-left py-2 font-medium">#</th>
                        <th class="text-left py-2 font-medium">Producto</th>
                        <th class="text-right py-2 font-medium">Unidades</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($topProductos as $i => $item)
                    <tr>
                        <td class="py-2.5 text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="py-2.5 font-medium text-slate-700">
                            {{ $item->product?->name ?? '(producto eliminado)' }}
                        </td>
                        <td class="py-2.5 text-right font-semibold text-petfy-dark">
                            {{ $item->total_vendido }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

{{-- ── Stock bajo ──────────────────────────────────────────────────── --}}
@if($stockBajo->isNotEmpty())
<div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-base font-semibold text-amber-600 mb-4">
        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
        Productos con stock bajo
    </h2>
    <div class="divide-y divide-slate-100">
        @foreach($stockBajo as $producto)
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-3">
                @if($producto->stock == 0)
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                @else
                    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
                @endif
                <a href="{{ route('admin.productos.edit', $producto) }}"
                   class="text-sm font-medium text-slate-700 hover:text-petfy transition">
                    {{ $producto->name }}
                </a>
            </div>
            <span class="text-sm font-bold {{ $producto->stock == 0 ? 'text-red-600' : 'text-amber-600' }}">
                {{ $producto->stock == 0 ? 'Sin stock' : $producto->stock . ' unid.' }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="bg-white rounded-2xl shadow p-6 flex items-center gap-3 text-green-700">
    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
    <p class="text-sm font-medium">Todos los productos activos tienen stock suficiente.</p>
</div>
@endif

@endsection
