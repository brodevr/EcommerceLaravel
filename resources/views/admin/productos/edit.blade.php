@extends('layouts.admin')
@section('title', 'Editar Producto')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.productos.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Editar Producto</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.productos.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-petfy mb-1">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                       class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition"
                       required>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-petfy mb-1">Descripción</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-petfy mb-1">Precio ($)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                           step="0.01" min="0"
                           class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition"
                           required>
                    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-petfy mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition">
                    @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-petfy mb-1">Imagen actual</label>
                <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}"
                     class="h-24 w-24 object-cover rounded-lg mb-2">
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-sm text-slate-600 border border-[#b2ebf2] rounded-lg px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-petfy/10 file:text-petfy file:font-medium hover:file:bg-petfy/20 transition">
                <p class="mt-1 text-xs text-slate-400">Dejá vacío para mantener la imagen actual.</p>
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-petfy mb-2">Categorías</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                   class="rounded border-[#b2ebf2] text-petfy focus:ring-petfy/30"
                                   {{ in_array($cat->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('categories') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-gradient-to-r from-petfy to-petfy-light text-white font-semibold px-6 py-2.5 rounded-lg hover:from-petfy-light hover:to-petfy transition">
                    Actualizar producto
                </button>
                <a href="{{ route('admin.productos.index') }}"
                   class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
