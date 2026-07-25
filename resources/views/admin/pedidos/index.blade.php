@extends('layouts.admin')
@section('title', 'Pedidos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-petfy-dark">Pedidos</h1>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-petfy-dark text-white">
            <tr>
                <th class="text-left px-4 py-3">#</th>
                <th class="text-left px-4 py-3">Cliente</th>
                <th class="text-right px-4 py-3">Total</th>
                <th class="text-left px-4 py-3 hidden sm:table-cell">Estado</th>
                <th class="text-left px-4 py-3 hidden md:table-cell">Fecha</th>
                <th class="px-4 py-3">Detalle</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($orders as $order)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-mono text-slate-500">#{{ $order->id }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $order->user->name }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-petfy-dark">
                        ${{ number_format($order->total, 2, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 hidden sm:table-cell">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $order->status->badgeClass() }}">
                            {{ $order->status->label() }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-500 hidden md:table-cell">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.pedidos.show', $order) }}"
                           class="text-petfy hover:text-petfy-dark transition" title="Ver detalle">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                        No hay pedidos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($orders->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
