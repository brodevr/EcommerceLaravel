@extends('layouts.petfy')
@section('title', 'Mi Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold text-petfy-dark mb-6">Mi Wishlist</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($productos as $producto)
        @if($loop->first)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @endif

        <div class="bg-white rounded-xl shadow hover:shadow-lg transition flex flex-col overflow-hidden">
            <img src="{{ asset('img/' . $producto->image) }}"
                 alt="{{ $producto->name }}"
                 class="h-48 w-full object-cover">
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-semibold text-slate-800">{{ $producto->name }}</h3>
                <p class="text-sm text-slate-500 mt-1 flex-1 line-clamp-2">{{ $producto->description }}</p>
                <p class="text-petfy font-bold text-lg mt-3">{{ $producto->formatted_price }}</p>

                <div class="mt-3 flex gap-2">
                    <a href="{{ route('products.show', $producto) }}"
                       class="flex-1 text-center bg-petfy text-white rounded-lg py-2 hover:bg-petfy-dark transition text-sm font-medium">
                        Ver producto
                    </a>
                    <form action="{{ route('wishlist.destroy', $producto) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-2 border border-red-200 text-red-500 rounded-lg hover:bg-red-50 transition text-sm">
                            <i class="fa-solid fa-heart-crack"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($loop->last)
        </div>
        @endif
    @empty
        <div class="text-center py-16 text-slate-400">
            <i class="fa-regular fa-heart text-5xl mb-4 block"></i>
            <p>Tu wishlist está vacía.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-petfy hover:underline">
                Ver productos
            </a>
        </div>
    @endforelse

</div>
@endsection
