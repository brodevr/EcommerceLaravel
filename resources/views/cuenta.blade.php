<x-guest-layout>

    <h2 class="text-xl font-bold text-petfy-dark mb-6 text-center">Mi Cuenta</h2>

    {{-- Opciones --}}
    <div class="flex flex-col gap-3">

        <a href="{{ route('login') }}"
           class="flex items-center gap-4 border border-slate-200 rounded-xl px-5 py-4 hover:border-petfy hover:bg-petfy/5 transition group">
            <div class="w-10 h-10 rounded-full bg-petfy/10 flex items-center justify-center flex-shrink-0 group-hover:bg-petfy/20 transition">
                <i class="fa-solid fa-right-to-bracket text-petfy"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-slate-800">Iniciar sesión</p>
                <p class="text-xs text-slate-400">Ya tengo una cuenta</p>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-petfy transition text-sm"></i>
        </a>

        <a href="{{ route('register') }}"
           class="flex items-center gap-4 border border-slate-200 rounded-xl px-5 py-4 hover:border-petfy hover:bg-petfy/5 transition group">
            <div class="w-10 h-10 rounded-full bg-petfy-accent/30 flex items-center justify-center flex-shrink-0 group-hover:bg-petfy-accent/50 transition">
                <i class="fa-solid fa-user-plus text-petfy-dark"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-slate-800">Crear cuenta</p>
                <p class="text-xs text-slate-400">Registrarme gratis</p>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-petfy transition text-sm"></i>
        </a>

    </div>

    {{-- Beneficios --}}
    <div class="mt-6 pt-5 border-t border-slate-100">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Con tu cuenta podés</p>
        <ul class="space-y-2">
            @foreach([
                ['fa-heart',        'text-red-400',    'Guardar productos en wishlist'],
                ['fa-box',          'text-petfy',      'Seguir el estado de tus pedidos'],
                ['fa-location-dot', 'text-amber-400',  'Gestionar direcciones de envío'],
                ['fa-star',         'text-yellow-400', 'Escribir reseñas de productos'],
            ] as [$icon, $color, $text])
                <li class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="fa-solid {{ $icon }} {{ $color }} w-4 text-center flex-shrink-0"></i>
                    {{ $text }}
                </li>
            @endforeach
        </ul>
    </div>

</x-guest-layout>
