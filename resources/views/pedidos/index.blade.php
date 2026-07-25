@extends('layouts.petfy')
@section('title', 'Mis Pedidos')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold text-petfy-dark mb-6">Mis Pedidos</h1>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-petfy-dark text-white">
                <tr>
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Fecha</th>
                    <th class="text-right px-4 py-3">Total</th>
                    <th class="text-left px-4 py-3 hidden sm:table-cell">Estado</th>
                    <th class="px-4 py-3">Detalle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-mono text-slate-500">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-petfy-dark">
                            ${{ number_format($order->total, 2, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 hidden sm:table-cell">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $order->status->badgeClass() }}">
                                {{ $order->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('orders.show', $order) }}"
                               class="text-petfy hover:text-petfy-dark transition">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                            No tenés pedidos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">{{ $orders->links() }}</div>
        @endif
    </div>

</div>
@endsection
