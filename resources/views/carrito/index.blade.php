@extends('layouts.petfy')
@section('title', 'Mi Carrito')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold text-petfy-dark mb-6">Mi Carrito</h1>

    @if(session('cart_success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            {{ session('cart_success') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="text-center py-20 text-slate-400">
            <i class="fa-solid fa-cart-shopping text-6xl mb-4 block"></i>
            <p class="text-lg">Tu carrito está vacío.</p>
            <a href="{{ route('products.index') }}"
               class="mt-5 inline-block bg-petfy text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-petfy-dark transition">
                Ver productos
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Lista de items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white rounded-2xl shadow p-4 flex flex-col sm:flex-row sm:items-center gap-3">

                        {{-- Imagen + info --}}
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <img src="{{ asset('img/' . $item['image']) }}"
                                 alt="{{ $item['name'] }}"
                                 class="h-16 w-16 object-cover rounded-xl flex-shrink-0">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-slate-800 truncate">{{ $item['name'] }}</h3>
                                <p class="text-petfy font-bold mt-0.5">
                                    ${{ number_format($item['price'], 2, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Controles: cantidad + subtotal + quitar --}}
                        <div class="flex items-center gap-3 justify-between sm:justify-end">

                            <form action="{{ route('cart.update', $id) }}" method="POST"
                                  class="flex items-center">
                                @csrf @method('PATCH')
                                <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                            class="px-3 py-1.5 text-slate-500 hover:bg-slate-100 transition font-bold">−</button>
                                    <span class="px-3 py-1.5 text-sm font-semibold text-slate-700 min-w-[2rem] text-center">
                                        {{ $item['quantity'] }}
                                    </span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                            class="px-3 py-1.5 text-slate-500 hover:bg-slate-100 transition font-bold">+</button>
                                </div>
                            </form>

                            <p class="font-bold text-slate-700 text-right tabular-nums">
                                ${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                            </p>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 transition p-1" title="Quitar">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach

                {{-- Vaciar carrito --}}
                <div class="text-right">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-sm text-slate-400 hover:text-red-500 transition underline">
                            Vaciar carrito
                        </button>
                    </form>
                </div>
            </div>

            {{-- Resumen --}}
            <div class="bg-white rounded-2xl shadow p-6 h-fit">
                <h2 class="text-lg font-bold text-petfy-dark mb-4">Resumen</h2>

                <div class="space-y-2 text-sm text-slate-600 mb-4">
                    @foreach($cart as $item)
                        <div class="flex justify-between">
                            <span class="truncate pr-2">{{ $item['name'] }} ×{{ $item['quantity'] }}</span>
                            <span class="flex-shrink-0 font-medium">
                                ${{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-4 flex justify-between font-bold text-slate-800 text-base">
                    <span>Total</span>
                    <span class="text-petfy-dark text-lg">
                        ${{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>

                @auth
                    <a href="{{ route('checkout') }}"
                       class="mt-5 block text-center bg-gradient-to-r from-petfy to-petfy-light text-white font-bold py-3 rounded-xl hover:from-petfy-light hover:to-petfy transition-all duration-300 ease-in-out shadow">
                        <i class="fa-solid fa-lock mr-2"></i>Finalizar pedido
                    </a>
                @else
                    <a href="{{ route('cuenta') }}"
                       class="mt-5 block text-center bg-gradient-to-r from-petfy to-petfy-light text-white font-bold py-3 rounded-xl hover:from-petfy-light hover:to-petfy transition shadow">
                        Iniciá sesión para comprar
                    </a>
                @endauth
            </div>

        </div>
    @endif

</div>
@endsection
