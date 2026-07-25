@extends('layouts.admin')
@section('title', 'Nueva Categoría')

@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categorias.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Nueva Categoría</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.categorias.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-petfy mb-1">Nombre</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition"
                       required>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-slate-400">El slug se genera automáticamente.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-petfy mb-1">Descripción</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border border-[#b2ebf2] rounded-lg px-3 py-2.5 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-gradient-to-r from-petfy to-petfy-light text-white font-semibold px-6 py-2.5 rounded-lg hover:from-petfy-light hover:to-petfy transition">
                    Guardar
                </button>
                <a href="{{ route('admin.categorias.index') }}"
                   class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
