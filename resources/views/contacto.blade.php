@extends('layouts.petfy')
@section('title', 'Contacto')

@section('content')

<section class="bg-gradient-to-r from-petfy to-petfy-dark text-white">
    <div class="max-w-7xl mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl font-extrabold drop-shadow mb-2">Contactanos</h1>
        <p class="text-petfy-accent font-medium">Respondemos a la brevedad.</p>
    </div>
</section>

<div class="max-w-xl mx-auto px-4 py-12">

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" value="Nombre" />
                <x-text-input id="name" name="name" type="text"
                              :value="old('name', auth()->user()?->name)"
                              required />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Correo electrónico" />
                <x-text-input id="email" name="email" type="email"
                              :value="old('email', auth()->user()?->email)"
                              required />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="message" value="Mensaje" />
                <textarea id="message" name="message" rows="5" required
                          class="w-full border border-[#b2ebf2] rounded-[0.7rem] px-4 py-2.5 text-slate-800 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition duration-150">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" />
            </div>

            <x-primary-button class="w-full py-3">
                <i class="fa-solid fa-paper-plane mr-2"></i> Enviar mensaje
            </x-primary-button>
        </form>
    </div>

</div>
@endsection
