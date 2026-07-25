@extends('layouts.petfy')
@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('orders.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Pedido #{{ $order->id }}</h1>
        <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $order->status->badgeClass() }}">
            {{ $order->status->label() }}
        </span>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <p class="text-sm text-slate-500">
                Pedido realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
            </p>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-4 py-2 text-slate-500">Producto</th>
                    <th class="text-right px-4 py-2 text-slate-500">Cant.</th>
                    <th class="text-right px-4 py-2 text-slate-500">Precio</th>
                    <th class="text-right px-4 py-2 text-slate-500">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $item->product->name }}</td>
                        <td class="px-4 py-3 text-right">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-right">${{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right font-semibold">
                            ${{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-slate-200 bg-slate-50">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold text-slate-700">Total</td>
                    <td class="px-4 py-3 text-right font-bold text-petfy-dark text-base">
                        ${{ number_format($order->total, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection
