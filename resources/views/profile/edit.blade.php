@extends('layouts.petfy')

@section('title', 'Mi Perfil')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10 space-y-6">

    <h1 class="text-2xl font-bold text-petfy-dark">Mi Perfil</h1>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-3 gap-3">
        @foreach([
            [route('orders.index'),     'fa-box',          'Mis pedidos'],
            [url('/wishlist'),          'fa-heart',        'Wishlist'],
            [route('direcciones.index'),'fa-location-dot', 'Direcciones'],
        ] as [$href, $icon, $label])
            <a href="{{ $href }}"
               class="flex flex-col items-center gap-2 bg-white border border-slate-200 rounded-xl py-4 hover:border-petfy hover:bg-petfy/5 transition group">
                <i class="fa-solid {{ $icon }} text-petfy text-xl group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-600">{{ $label }}</span>
            </a>
        @endforeach
    </div>

    {{-- Información personal --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-base font-semibold text-petfy-dark mb-4">Información personal</h2>
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Contraseña --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-base font-semibold text-petfy-dark mb-4">Cambiar contraseña</h2>
        @include('profile.partials.update-password-form')
    </div>

    {{-- Eliminar cuenta --}}
    <div class="bg-white rounded-xl border border-red-100 p-6">
        <h2 class="text-base font-semibold text-red-500 mb-4">Zona de peligro</h2>
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection
