<nav class="bg-gradient-to-r from-petfy-light to-petfy shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('img/Logo.png') }}" alt="PetFy"
                 class="h-12 w-12 rounded-full shadow object-cover">
            <span class="text-white font-bold text-lg hidden sm:block">PetFy Pet Shop</span>
        </a>

        <div class="flex items-center gap-1 sm:gap-3 text-white font-medium">
            <a href="{{ route('home') }}"
               class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Inicio</a>

            @guest
                <a href="{{ url('/nosotros') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Nosotros</a>
                <a href="{{ url('/contacto') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Contacto</a>
                <a href="{{ route('login') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Login</a>
                <a href="{{ route('register') }}"
                   class="px-3 py-2 rounded-lg bg-petfy-accent text-petfy-dark font-semibold hover:brightness-95 transition">
                    Registrarse
                </a>
            @endguest

            @auth
                <a href="{{ url('/productos') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Productos</a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ url('/admin/productos') }}"
                       class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Panel</a>
                @else
                    <a href="{{ url('/wishlist') }}"
                       class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">
                        <i class="fa-solid fa-heart"></i> Wishlist
                    </a>
                    <a href="{{ url('/pedidos') }}"
                       class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">Mis pedidos</a>
                @endif

                <span class="px-3 py-2 text-white/80 hidden sm:inline text-sm">
                    Hola, {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition">
                        Salir
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>
