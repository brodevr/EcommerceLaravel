@extends('layouts.petfy')

@section('title', 'Inicio')

@section('content')

    {{-- BANNER --}}
    <section class="bg-gradient-to-r from-petfy to-petfy-dark text-white">
        <div class="max-w-7xl mx-auto px-4 py-16 text-center">
            <h1 class="text-4xl sm:text-5xl font-extrabold drop-shadow mb-3">
                ¡Bienvenidos a PetFy Pet Shop!
            </h1>
            <p class="text-lg text-petfy-accent font-medium">
                Todo para tu mascota en un solo lugar.
            </p>
            @guest
                <a href="{{ route('register') }}"
                   class="mt-6 inline-block bg-petfy-accent text-petfy-dark font-bold px-6 py-3 rounded-xl hover:brightness-95 transition shadow">
                    Crear cuenta gratis
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
                        <img src="{{ asset('img/' . $producto->image) }}"
                             alt="{{ $producto->name }}"
                             class="h-48 w-full object-cover">

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-slate-800">{{ $producto->name }}</h3>
                            <p class="text-sm text-slate-500 mt-1 flex-1 line-clamp-2">
                                {{ $producto->description }}
                            </p>
                            <p class="text-petfy font-bold text-lg mt-3">
                                {{ $producto->formatted_price }}
                            </p>

                            <a href="{{ url('/productos/' . $producto->id) }}"
                               class="mt-3 inline-block text-center bg-petfy text-white rounded-lg py-2 hover:bg-petfy-dark transition font-medium">
                                Ver producto
                            </a>
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
