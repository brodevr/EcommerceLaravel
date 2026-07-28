@extends('layouts.petfy')

@section('title', 'Inicio')

@section('content')

    {{-- BANNER --}}
    <style>.hero-banner{background-image:url('{{ asset('img/banner.jpg') }}');}</style>
    <section class="hero-banner relative text-white overflow-hidden bg-left md:bg-center"
             style="background-size:cover;">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 text-left sm:px-8 sm:py-32 md:py-44">
            <h1 class="text-3xl sm:text-4xl font-extrabold drop-shadow mb-3">
                ¡Bienvenidos a PetFy Pet Shop!
            </h1>
            <p class="text-base text-petfy-accent font-medium">
                Todo para tu mascota en un solo lugar.
            </p>
            @guest
                <a href="{{ route('register') }}"
                   class="mt-6 inline-block bg-petfy-accent text-petfy-dark font-bold px-6 py-3 rounded-xl hover:brightness-95 transition shadow">
                    Crear cuenta
                </a>
            @endguest
        </div>
    </section>

    {{-- BENEFICIOS --}}
    <section class="max-w-7xl mx-auto px-4 -mt-6 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([
                ['fa-truck',       'Envíos a Domicilio'],
                ['fa-credit-card', 'Todos los Medios de Pago'],
                ['fa-circle-check','Productos Garantizados'],
                ['fa-gift',        'Promos y Descuentos'],
            ] as [$icono, $texto])
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center">
                    <i class="fa-solid {{ $icono }} text-2xl text-petfy mb-2"></i>
                    <span class="text-sm font-semibold text-slate-700">{{ $texto }}</span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- GRID DE PRODUCTOS --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-center text-petfy-dark mb-8">
            Nuestros Productos
        </h2>

        @if ($productos->isEmpty())
            <p class="text-center text-slate-500">No hay productos disponibles todavía.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col overflow-hidden">
                        <div class="w-full h-52 bg-slate-50 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('img/' . $producto->image) }}"
                                 alt="{{ $producto->name }}"
                                 class="h-full w-full object-contain">
                        </div>

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-slate-800">{{ $producto->name }}</h3>
                            @if($producto->categories->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($producto->categories as $cat)
                                        <span class="text-xs bg-petfy/10 text-petfy-dark px-2 py-0.5 rounded-full font-medium">
                                            {{ $cat->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            <p class="text-sm text-slate-500 mt-1 flex-1 line-clamp-2">
                                {{ $producto->description }}
                            </p>
                            <p class="text-petfy font-bold text-lg mt-3">
                                {{ $producto->formatted_price }}
                            </p>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ url('/productos/' . $producto->id) }}"
                                   class="flex-1 text-center bg-petfy text-white rounded-lg py-2 hover:bg-petfy-dark transition font-medium text-sm">
                                    Ver producto
                                </a>
                                <form action="{{ route('cart.add', $producto->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Agregar al carrito"
                                            class="px-3 py-2 bg-petfy-accent text-petfy-dark rounded-lg hover:brightness-95 transition font-bold text-sm">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                                @auth
                                    <form action="{{ route('wishlist.store', $producto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="Agregar a wishlist"
                                                class="px-3 py-2 bg-white border border-slate-200 text-slate-400 rounded-lg hover:text-red-400 hover:border-red-200 transition text-sm">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" title="Agregar a wishlist"
                                       class="px-3 py-2 bg-white border border-slate-200 text-slate-400 rounded-lg hover:text-red-400 hover:border-red-200 transition text-sm">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $productos->links() }}
            </div>
        @endif
    </section>

@endsection
