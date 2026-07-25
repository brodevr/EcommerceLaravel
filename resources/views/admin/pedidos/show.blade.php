@extends('layouts.admin')
@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pedidos.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Pedido #{{ $order->id }}</h1>
        <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $order->status->badgeClass() }}">
            {{ $order->status->label() }}
        </span>
    </div>

    <div class="grid gap-6">

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Cliente</h2>
            <p class="font-semibold text-slate-800">{{ $order->user->name }}</p>
            <p class="text-slate-500 text-sm">{{ $order->user->email }}</p>
            <p class="text-slate-400 text-xs mt-1">
                Pedido el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Productos</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-4 py-2 text-slate-500">Producto</th>
                        <th class="text-right px-4 py-2 text-slate-500">Cant.</th>
                        <th class="text-right px-4 py-2 text-slate-500">Precio unit.</th>
                        <th class="text-right px-4 py-2 text-slate-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $item->product->name }}</td>
                            <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-right">${{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 text-right font-semibold">
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

        @php $transitions = $order->status->transitions(); @endphp
        @if(count($transitions) > 0)
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Cambiar estado</h2>
                <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST"
                      class="flex flex-wrap items-center gap-3">
                    @csrf @method('PATCH')
                    <select name="status"
                            class="border border-[#b2ebf2] rounded-lg px-3 py-2 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition text-sm">
                        @foreach($transitions as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="bg-gradient-to-r from-petfy to-petfy-light text-white font-semibold px-5 py-2 rounded-lg hover:from-petfy-light hover:to-petfy transition text-sm">
                        Actualizar estado
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection
