@extends('layouts.petfy')
@section('title', 'Mis Direcciones')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-petfy-dark">Mis Direcciones</h1>
        <a href="{{ route('direcciones.create') }}"
           class="bg-petfy text-white font-semibold px-4 py-2 rounded-lg hover:bg-petfy-dark transition text-sm">
            <i class="fa-solid fa-plus mr-1"></i> Nueva
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4">
        @forelse($addresses as $address)
            <div class="bg-white rounded-xl shadow p-5 flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    @if($address->label)
                        <span class="text-xs bg-petfy/10 text-petfy-dark font-semibold px-2 py-0.5 rounded-full">{{ $address->label }}</span>
                    @endif
                    <p class="font-semibold text-slate-800 mt-1">{{ $address->recipient }}</p>
                    <p class="text-slate-500 text-sm">{{ $address->street }}, {{ $address->city }}
                        @if($address->state), {{ $address->state }}@endif
                        @if($address->postal_code) — CP {{ $address->postal_code }}@endif
                    </p>
                    @if($address->is_default)
                        <span class="text-xs text-petfy font-medium"><i class="fa-solid fa-star text-xs mr-1"></i>Principal</span>
                    @endif
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('direcciones.edit', ['address' => $address]) }}"
                       class="text-petfy hover:text-petfy-dark transition" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('direcciones.destroy', ['address' => $address]) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar esta dirección?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-slate-400">
                <i class="fa-solid fa-location-dot text-4xl mb-3 block"></i>
                <p>No tenés direcciones guardadas.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
