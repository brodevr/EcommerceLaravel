@extends('layouts.petfy')
@section('title', 'Finalizar pedido')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('cart.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Finalizar pedido</h1>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Dirección de envío --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-base font-bold text-petfy-dark mb-4">
                        <i class="fa-solid fa-location-dot mr-2 text-petfy"></i>Dirección de envío
                    </h2>

                    @if($addresses->isEmpty())
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-700 flex items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation mt-0.5 flex-shrink-0"></i>
                            <div>
                                No tenés direcciones guardadas. El pedido se creará sin dirección de envío.
                                <a href="{{ route('direcciones.create') }}" class="underline font-semibold ml-1">Agregar dirección</a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($addresses as $address)
                                <label class="flex items-start gap-3 border rounded-xl p-4 cursor-pointer transition
                                              has-[:checked]:border-petfy has-[:checked]:bg-petfy/5 border-slate-200 hover:border-petfy/50">
                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                           {{ $address->is_default ? 'checked' : '' }}
                                           class="mt-1 text-petfy focus:ring-petfy/30 flex-shrink-0">
                                    <div class="flex-1 text-sm">
                                        <p class="font-semibold text-slate-800">
                                            {{ $address->label ?? $address->recipient }}
                                            @if($address->is_default)
                                                <span class="ml-2 text-xs bg-petfy/10 text-petfy px-2 py-0.5 rounded-full">Principal</span>
                                            @endif
                                        </p>
                                        <p class="text-slate-500 mt-0.5">{{ $address->street }}, {{ $address->city }}
                                            @if($address->state), {{ $address->state }}@endif
                                        </p>
                                        @if($address->phone)
                                            <p class="text-slate-400 text-xs mt-0.5"><i class="fa-solid fa-phone mr-1"></i>{{ $address->phone }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <a href="{{ route('direcciones.create') }}"
                           class="mt-3 inline-block text-sm text-petfy hover:text-petfy-dark transition underline">
                            + Agregar nueva dirección
                        </a>
                    @endif
                </div>

                {{-- Resumen de productos --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-base font-bold text-petfy-dark mb-4">
                        <i class="fa-solid fa-box mr-2 text-petfy"></i>Productos
                    </h2>
                    <div class="space-y-3">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('img/' . $item['image']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-12 h-12 rounded-lg object-cover flex-shrink-0 border border-slate-100">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-slate-400">Cant.: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 flex-shrink-0">
                                    ${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Panel de pago --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow p-6 h-fit sticky top-4">
                    <h2 class="text-base font-bold text-petfy-dark mb-4">Resumen</h2>

                    <div class="space-y-2 text-sm text-slate-600 mb-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between">
                                <span class="truncate pr-2">{{ $item['name'] }} ×{{ $item['quantity'] }}</span>
                                <span class="flex-shrink-0">${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex justify-between font-bold text-slate-800 mb-6">
                        <span>Total</span>
                        <span class="text-petfy-dark text-lg">${{ number_format($total, 2, ',', '.') }}</span>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-petfy to-petfy-light text-white font-bold py-3 rounded-xl hover:from-petfy-light hover:to-petfy transition-all duration-300 ease-in-out shadow">
                        <i class="fa-solid fa-check mr-2"></i>Confirmar pedido
                    </button>

                    <a href="{{ route('cart.index') }}"
                       class="mt-3 block text-center text-sm text-slate-400 hover:text-slate-600 transition">
                        ← Volver al carrito
                    </a>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
