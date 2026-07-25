@extends('layouts.petfy')

@section('title', $product->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-petfy">Inicio</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-petfy">Productos</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden md:flex">

        {{-- Imagen --}}
        <div class="md:w-2/5 flex-shrink-0">
            <img src="{{ asset('img/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-72 md:h-full object-cover">
        </div>

        {{-- Detalle --}}
        <div class="p-6 md:p-8 flex flex-col flex-1">

            {{-- Categorías --}}
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($product->categories as $cat)
                    <a href="{{ route('categories.show', $cat) }}"
                       class="text-xs font-semibold bg-petfy/10 text-petfy px-3 py-1 rounded-full hover:bg-petfy/20 transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <h1 class="text-2xl font-bold text-slate-800 mb-2">{{ $product->name }}</h1>

            {{-- Puntuación --}}
            @if($averageRating)
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= round($averageRating) ? 'solid' : 'regular' }} fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="text-sm text-slate-500">{{ number_format($averageRating, 1) }} / 5</span>
                </div>
            @endif

            <p class="text-slate-600 mb-4 leading-relaxed">{{ $product->description }}</p>

            <p class="text-3xl font-extrabold text-petfy mb-4">{{ $product->formatted_price }}</p>

            {{-- Stock --}}
            @if($product->stock > 0)
                <p class="text-sm text-green-600 font-medium mb-4">
                    <i class="fa-solid fa-circle-check mr-1"></i> En stock ({{ $product->stock }} disponibles)
                </p>
            @else
                <p class="text-sm text-red-500 font-medium mb-4">
                    <i class="fa-solid fa-circle-xmark mr-1"></i> Sin stock
                </p>
            @endif

            {{-- Flash carrito --}}
            @if(session('cart_success'))
                <div class="mb-3 bg-green-50 border border-green-200 text-green-700 rounded-lg px-3 py-2 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('cart_success') }}
                </div>
            @endif

            {{-- Acciones --}}
            <div class="flex flex-wrap gap-3 mt-auto">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-gradient-to-r from-petfy to-petfy-light text-white font-semibold px-6 py-3 rounded-xl hover:from-petfy-light hover:to-petfy transition shadow-md">
                        <i class="fa-solid fa-cart-plus mr-2"></i>Agregar al carrito
                    </button>
                </form>
                <a href="{{ route('cart.index') }}"
                   class="px-5 py-3 border-2 border-petfy text-petfy font-semibold rounded-xl hover:bg-petfy/10 transition">
                    <i class="fa-solid fa-cart-shopping mr-1"></i>Ver carrito
                </a>
            </div>
        </div>
    </div>

    {{-- Reseñas --}}
    <div class="mt-10 grid md:grid-cols-3 gap-8">

        {{-- Lista --}}
        <div class="md:col-span-2">
            <h2 class="text-xl font-bold text-slate-700 mb-4">Reseñas de clientes</h2>

            @if(session('review_success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('review_success') }}
                </div>
            @endif
            @if(session('review_error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('review_error') }}
                </div>
            @endif

            @forelse($product->reviews as $review)
                <div class="bg-white rounded-xl shadow p-4 mb-4">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="font-semibold text-slate-700">{{ $review->user->name }}</span>
                        <div class="flex text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-slate-400 ml-auto">{{ $review->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($review->comment)
                        <p class="text-slate-600 text-sm mt-1">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-slate-500 text-sm">Todavía no hay reseñas para este producto.</p>
            @endforelse
        </div>

        {{-- Formulario --}}
        <div>
            <h2 class="text-xl font-bold text-slate-700 mb-4">Tu reseña</h2>

            @auth
                @if($canReview)
                    <form action="{{ route('reviews.store', $product) }}" method="POST"
                          class="bg-white rounded-xl shadow p-5 space-y-4">
                        @csrf

                        {{-- Estrellas --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Puntuación</label>
                            <div class="flex gap-1" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}"
                                               class="sr-only" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <i class="fa-regular fa-star text-2xl text-yellow-400 hover:fa-solid transition star-icon"></i>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-1" />
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-medium text-slate-600 mb-1">Comentario (opcional)</label>
                            <textarea id="comment" name="comment" rows="3"
                                      class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/30 focus:border-petfy resize-none"
                                      placeholder="Contá tu experiencia con este producto...">{{ old('comment') }}</textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-1" />
                        </div>

                        <x-primary-button class="w-full justify-center">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Enviar reseña
                        </x-primary-button>
                    </form>
                @elseif($alreadyReviewed)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm text-slate-500 text-center">
                        <i class="fa-solid fa-circle-check text-green-500 text-xl mb-2 block"></i>
                        Ya dejaste una reseña para este producto.
                    </div>
                @endif
            @else
                <div class="bg-white rounded-xl shadow p-5 text-center text-sm text-slate-500">
                    <i class="fa-solid fa-user text-petfy text-2xl mb-2 block"></i>
                    <a href="{{ route('login') }}" class="text-petfy font-semibold hover:underline">Iniciá sesión</a>
                    para dejar una reseña.
                </div>
            @endauth
        </div>
    </div>

    <script>
        document.querySelectorAll('#star-rating input[type=radio]').forEach((radio, idx, radios) => {
            radio.addEventListener('change', () => {
                radios.forEach((r, i) => {
                    const icon = r.nextElementSibling;
                    icon.className = i <= idx
                        ? 'fa-solid fa-star text-2xl text-yellow-400 star-icon'
                        : 'fa-regular fa-star text-2xl text-yellow-400 star-icon';
                });
            });
        });
    </script>

</div>
@endsection
