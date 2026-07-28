<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold text-petfy-dark mb-6 text-center">Iniciar sesión</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" type="email" name="email"
                          :value="old('email')"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-password-input id="password" name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-[#b2ebf2] text-petfy shadow-sm focus:ring-petfy/30">
                <span class="text-sm text-slate-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-petfy hover:text-petfy-dark underline focus:outline-none focus:ring-2 focus:ring-petfy/40 rounded transition">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full py-3">
                Ingresar
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-slate-500 mt-5">
            ¿No tenés cuenta?
            <a href="{{ route('register') }}"
               class="text-petfy font-semibold hover:text-petfy-dark underline transition">
                Registrarse
            </a>
        </p>
    </form>
</x-guest-layout>
