@extends('layouts.admin')
@section('title', 'Editar usuario')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.usuarios.index') }}"
       class="text-petfy hover:text-petfy-dark transition" title="Volver">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-petfy-dark">Editar usuario</h1>
</div>

<div class="max-w-lg bg-white rounded-2xl shadow p-6">
    {{-- Avatar inicial --}}
    <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
        <div class="w-11 h-11 rounded-full bg-petfy flex items-center justify-center text-white font-bold text-lg select-none">
            {{ strtoupper(mb_substr($usuario->name, 0, 1)) }}
        </div>
        <div>
            <p class="font-semibold text-slate-800">{{ $usuario->name }}</p>
            <p class="text-xs text-slate-400">Registrado {{ $usuario->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/40
                          {{ $errors->has('name') ? 'border-red-400' : 'border-slate-300' }}">
            @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/40
                          {{ $errors->has('email') ? 'border-red-400' : 'border-slate-300' }}">
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Rol --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Rol</label>

            @if(auth()->id() === $usuario->id)
                {{-- El admin no puede cambiar su propio rol --}}
                <input type="hidden" name="role" value="{{ $usuario->role->value }}">
                <div class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2 text-sm text-slate-400 flex items-center gap-2 cursor-not-allowed">
                    <i class="fa-solid fa-lock text-xs"></i>
                    {{ $usuario->role->label() }} — no podés cambiar tu propio rol
                </div>
            @else
                <select name="role"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-petfy/40
                               {{ $errors->has('role') ? 'border-red-400' : 'border-slate-300' }}">
                    @foreach(\App\Enums\Role::cases() as $rol)
                        <option value="{{ $rol->value }}"
                                {{ old('role', $usuario->role->value) === $rol->value ? 'selected' : '' }}>
                            {{ $rol->label() }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            @endif
        </div>

        {{-- Acciones --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-petfy text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-petfy-dark transition">
                Guardar cambios
            </button>
            <a href="{{ route('admin.usuarios.index') }}"
               class="px-5 py-2 rounded-lg text-sm text-slate-600 border border-slate-200 hover:bg-slate-50 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
