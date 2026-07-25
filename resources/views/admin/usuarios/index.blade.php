@extends('layouts.admin')
@section('title', 'Usuarios')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-petfy-dark">Usuarios</h1>
    <span class="text-sm text-slate-500">{{ $usuarios->total() }} registrados</span>
</div>

{{-- Buscador + filtro --}}
<form method="GET" action="{{ route('admin.usuarios.index') }}"
      class="bg-white rounded-2xl shadow p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-medium text-slate-500 mb-1">Buscar</label>
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               placeholder="Nombre o email…"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/40">
    </div>
    <div>
        <label class="block text-xs font-medium text-slate-500 mb-1">Rol</label>
        <select name="rol"
                class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/40">
            <option value="">Todos</option>
            <option value="admin"   {{ request('rol') === 'admin'   ? 'selected' : '' }}>Administrador</option>
            <option value="cliente" {{ request('rol') === 'cliente' ? 'selected' : '' }}>Cliente</option>
        </select>
    </div>
    <button type="submit"
            class="bg-petfy text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-petfy-dark transition">
        <i class="fa-solid fa-magnifying-glass mr-1"></i>Filtrar
    </button>
    @if(request('buscar') || request('rol'))
        <a href="{{ route('admin.usuarios.index') }}"
           class="text-sm text-slate-500 hover:text-petfy px-3 py-2 rounded-lg border border-slate-200 hover:border-petfy transition">
            Limpiar
        </a>
    @endif
</form>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-petfy-dark text-white">
            <tr>
                <th class="text-left px-4 py-3">Nombre</th>
                <th class="text-left px-4 py-3 hidden sm:table-cell">Email</th>
                <th class="text-left px-4 py-3">Rol</th>
                <th class="text-left px-4 py-3 hidden md:table-cell">Registro</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($usuarios as $usuario)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">
                    {{ $usuario->name }}
                    @if(auth()->id() === $usuario->id)
                        <span class="ml-1 text-xs text-slate-400">(vos)</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-slate-500 hidden sm:table-cell">{{ $usuario->email }}</td>
                <td class="px-4 py-3">
                    @if($usuario->role === \App\Enums\Role::Admin)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-petfy-dark text-white">
                            <i class="fa-solid fa-shield-halved text-[10px]"></i> Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                            <i class="fa-solid fa-user text-[10px]"></i> Cliente
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-slate-400 text-xs hidden md:table-cell">
                    {{ $usuario->created_at->format('d/m/Y') }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                           class="text-petfy hover:text-petfy-dark transition" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @if(auth()->id() !== $usuario->id)
                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                  onsubmit="return confirm('¿Eliminar a {{ addslashes($usuario->name) }}?\n\nEsta acción también borrará todos sus pedidos y no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="text-slate-300 cursor-not-allowed" title="No podés eliminarte a vos mismo">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-10 text-center text-slate-400">
                    <i class="fa-solid fa-users-slash text-2xl mb-2 block"></i>
                    No se encontraron usuarios con esos criterios.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($usuarios->hasPages())
        <div class="px-4 py-4 border-t border-slate-100">
            {{ $usuarios->links() }}
        </div>
    @endif
</div>
@endsection
