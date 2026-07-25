@extends('layouts.petfy')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold text-petfy-dark mb-6">Catálogo de Productos</h1>

    {{-- Filtro por categoría (pills) --}}
    @php $selected = $activeSlug ?? request('categoria', ''); @endphp
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('products.index') }}"
           class="px-4 py-1.5 rounded-full text-sm font-semibold border transition
                  {{ $selected === '' ? 'bg-petfy text-white border-petfy' : 'bg-white text-petfy-dark border-petfy/30 hover:bg-petfy/10' }}">
            Todas
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['categoria' => $cat->slug]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold border transition
                      {{ $selected === $cat->slug ? 'bg-petfy text-white border-petfy' : 'bg-white text-petfy-dark border-petfy/30 hover:bg-petfy/10' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- Grid de productos --}}
    @forelse($products as $product)
        @if($loop->first)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @endif

        <div class="bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col overflow-hidden">
            <div class="w-full h-52 bg-slate-50 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('img/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-contain">
            </div>

            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-semibold text-slate-800">{{ $product->name }}</h3>

                @if($product->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($product->categories as $cat)
                            <a href="{{ route('products.index', ['categoria' => $cat->slug]) }}"
                               class="text-xs bg-petfy/10 text-petfy-dark px-2 py-0.5 rounded-full font-medium hover:bg-petfy/20 transition">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <p class="text-sm text-slate-500 mt-2 flex-1 line-clamp-2">
                    {{ $product->description }}
                </p>
                <p class="text-petfy font-bold text-lg mt-3">
                    {{ $product->formatted_price }}
                </p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('products.show', $product) }}"
                       class="flex-1 text-center bg-petfy text-white rounded-lg py-2 hover:bg-petfy-dark transition font-medium text-sm">
                        Ver producto
                    </a>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Agregar al carrito"
                                class="px-3 py-2 bg-petfy-accent text-petfy-dark rounded-lg hover:brightness-95 transition font-bold text-sm">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                    @auth
                        <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
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

        @if($loop->last)
        </div>
        @endif
    @empty
        <p class="text-center text-slate-500 py-16">No hay productos disponibles en esta categoría.</p>
    @endforelse

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>
@endsection
