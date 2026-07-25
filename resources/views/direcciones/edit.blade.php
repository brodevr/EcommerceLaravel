@extends('layouts.petfy')
@section('title', 'Editar Dirección')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('direcciones.index') }}" class="text-petfy hover:text-petfy-dark transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-petfy-dark">Editar Dirección</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('direcciones.update', $address) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <x-input-label for="recipient" value="Nombre del destinatario *" />
                <x-text-input id="recipient" name="recipient" type="text"
                              :value="old('recipient', $address->recipient)" required />
                <x-input-error :messages="$errors->get('recipient')" />
            </div>

            <div>
                <x-input-label for="label" value="Etiqueta (ej: Casa, Trabajo)" />
                <x-text-input id="label" name="label" type="text"
                              :value="old('label', $address->label)" placeholder="Opcional" />
                <x-input-error :messages="$errors->get('label')" />
            </div>

            <div>
                <x-input-label for="street" value="Calle y número *" />
                <x-text-input id="street" name="street" type="text"
                              :value="old('street', $address->street)" required />
                <x-input-error :messages="$errors->get('street')" />
            </div>

            <div>
                <x-input-label for="city" value="Ciudad *" />
                <x-text-input id="city" name="city" type="text"
                              :value="old('city', $address->city)" required />
                <x-input-error :messages="$errors->get('city')" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="state" value="Provincia" />
                    <x-text-input id="state" name="state" type="text"
                                  :value="old('state', $address->state)" />
                    <x-input-error :messages="$errors->get('state')" />
                </div>
                <div>
                    <x-input-label for="postal_code" value="Código Postal" />
                    <x-text-input id="postal_code" name="postal_code" type="text"
                                  :value="old('postal_code', $address->postal_code)" />
                    <x-input-error :messages="$errors->get('postal_code')" />
                </div>
            </div>

            <div>
                <x-input-label for="phone" value="Teléfono de contacto" />
                <x-text-input id="phone" name="phone" type="text"
                              :value="old('phone', $address->phone)" placeholder="Opcional" />
                <x-input-error :messages="$errors->get('phone')" />
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_default" value="1"
                       {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-petfy focus:ring-petfy/30">
                <span class="text-sm text-slate-600">Usar como dirección principal</span>
            </label>

            <div class="flex gap-3 pt-2">
                <x-primary-button class="px-6 py-2.5">Actualizar</x-primary-button>
                <a href="{{ route('direcciones.index') }}"
                   class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition text-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
