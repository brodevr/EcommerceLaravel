@extends('layouts.admin')
@section('title', 'Categorías')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-petfy-dark">Categorías</h1>
    <a href="{{ route('admin.categorias.create') }}"
       class="bg-petfy text-white font-semibold px-4 py-2 rounded-lg hover:bg-petfy-dark transition">
        <i class="fa-solid fa-plus mr-1"></i> Nueva categoría
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-petfy-dark text-white">
            <tr>
                <th class="text-left px-4 py-3">Nombre</th>
                <th class="text-left px-4 py-3 hidden md:table-cell">Descripción</th>
                <th class="text-left px-4 py-3 hidden sm:table-cell">Slug</th>
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $category->name }}</td>
                    <td class="px-4 py-3 text-slate-500 hidden md:table-cell">
                        {{ Str::limit($category->description, 60) }}
                    </td>
                    <td class="px-4 py-3 text-slate-400 font-mono text-xs hidden sm:table-cell">
                        {{ $category->slug }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.categorias.edit', ['category' => $category]) }}"
                               class="text-petfy hover:text-petfy-dark transition" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.categorias.destroy', ['category' => $category]) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                        No hay categorías registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
