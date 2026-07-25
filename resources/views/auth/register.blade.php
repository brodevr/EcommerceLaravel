<x-guest-layout>
    <h2 class="text-xl font-bold text-petfy-dark mb-6 text-center">Crear cuenta</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name" type="text" name="name"
                          :value="old('name')"
                          required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" type="email" name="email"
                          :value="old('email')"
                          required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
            <p class="mt-1 text-xs text-slate-400">
                Mínimo 8 caracteres, una mayúscula, una minúscula y un número.
            </p>
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" type="password"
                          name="password_confirmation"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full py-3">
                Crear cuenta
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-slate-500 mt-5">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}"
               class="text-petfy font-semibold hover:text-petfy-dark underline transition">
                Iniciar sesión
            </a>
        </p>
    </form>
</x-guest-layout>
