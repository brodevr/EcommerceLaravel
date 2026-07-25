<nav class="bg-gradient-to-r from-petfy-light to-petfy shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-2">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 flex-1">
            <img src="{{ asset('img/Logo.png') }}" alt="PetFy"
                 class="h-12 w-12 rounded-full shadow object-cover">
            <span class="text-white font-bold text-lg hidden md:block">PetFy Pet Shop</span>
        </a>

        @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp

        {{-- Links centrados --}}
        <div class="flex-1 flex items-center justify-center gap-1 text-white font-medium">
            <a href="{{ route('home') }}"
               class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm">Inicio</a>
            <a href="{{ url('/productos') }}"
               class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm">Productos</a>
            <a href="{{ url('/nosotros') }}"
               class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm hidden sm:block">Nosotros</a>
            <a href="{{ url('/contacto') }}"
               class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm hidden sm:block">Contacto</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin/productos') }}"
                       class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm">Panel</a>
                @endif
            @endauth
        </div>

        {{-- Acciones (derecha) --}}
        <div class="flex items-center justify-end gap-1 text-white flex-1">
            @guest
                <a href="{{ route('cart.index') }}"
                   class="relative px-3 py-2 rounded-lg hover:bg-petfy-dark transition">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-petfy-accent text-petfy-dark text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center leading-none">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('cuenta') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition" title="Wishlist">
                    <i class="fa-solid fa-heart text-lg"></i>
                </a>
                <a href="{{ route('cuenta') }}"
                   class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition" title="Mi cuenta">
                    <i class="fa-solid fa-user text-lg"></i>
                </a>
            @endguest

            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('cart.index') }}"
                       class="relative px-3 py-2 rounded-lg hover:bg-petfy-dark transition">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-petfy-accent text-petfy-dark text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center leading-none">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ url('/wishlist') }}"
                       class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition" title="Wishlist">
                        <i class="fa-solid fa-heart text-lg"></i>
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition" title="Mi cuenta">
                    <i class="fa-solid fa-user text-lg"></i>
                    <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-sm font-medium">
                        Salir
                    </button>
                </form>
            @endauth
        </div>

    </div>
</nav>
