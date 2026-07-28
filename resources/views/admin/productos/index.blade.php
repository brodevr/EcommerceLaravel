@extends('layouts.admin')
@section('title', 'Productos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-petfy-dark">Productos</h1>
    <a href="{{ route('admin.productos.create') }}"
       class="bg-petfy text-white font-semibold px-4 py-2 rounded-lg hover:bg-petfy-dark transition">
        <i class="fa-solid fa-plus mr-1"></i> Nuevo producto
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-petfy-dark text-white">
            <tr>
                <th class="text-left px-4 py-3">Imagen</th>
                <th class="text-left px-4 py-3">Nombre</th>
                <th class="text-left px-4 py-3 hidden md:table-cell">Categorías</th>
                <th class="text-right px-4 py-3">Precio</th>
                <th class="text-right px-4 py-3 hidden sm:table-cell">Stock</th>
                <th class="text-center px-4 py-3 hidden sm:table-cell">Estado</th>
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($products as $product)
                <tr class="hover:bg-slate-50 transition {{ !$product->is_active ? 'opacity-50' : '' }}">
                    <td class="px-4 py-2">
                        <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}"
                             class="h-10 w-10 object-cover rounded-lg">
                    </td>
                    <td class="px-4 py-2 font-medium text-slate-800">{{ $product->name }}</td>
                    <td class="px-4 py-2 hidden md:table-cell">
                        <div class="flex flex-wrap gap-1">
                            @foreach($product->categories as $cat)
                                <span class="text-xs bg-petfy/10 text-petfy px-2 py-0.5 rounded-full">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-2 text-right font-semibold text-petfy-dark">
                        {{ $product->formatted_price }}
                    </td>
                    <td class="px-4 py-2 text-right hidden sm:table-cell">
                        <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center hidden sm:table-cell">
                        <form action="{{ route('admin.productos.toggleActive', ['product' => $product]) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="text-xs font-semibold px-2.5 py-1 rounded-full transition {{ $product->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-200 text-slate-500 hover:bg-slate-300' }}"
                                    title="{{ $product->is_active ? 'Click para desactivar' : 'Click para activar' }}">
                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.productos.edit', ['product' => $product]) }}"
                               class="text-petfy hover:text-petfy-dark transition" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.productos.destroy', ['product' => $product]) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este producto?\n\nSi tiene pedidos asociados no se podrá eliminar; usá el estado Activo/Inactivo en su lugar.')">
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
                    <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                        No hay productos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($products->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">{{ $products->links() }}</div>
    @endif
</div>
@endsection
