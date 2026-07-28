@php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp

@if(auth()->check() && auth()->user()->isAdmin())

{{-- ══════════════  NAV ADMIN  ══════════════ --}}
<nav class="relative bg-petfy-dark text-white shadow-lg"
     x-data="{ open: false }"
     @resize.window="if (window.innerWidth >= 768) open = false">

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center h-14">

            {{-- Logo + badge --}}
            <div class="flex-1 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold">
                    <img src="{{ asset('img/Logo.png') }}" class="h-9 w-9 rounded-full object-cover" alt="PetFy">
                    <span class="hidden sm:inline text-sm">PetFy</span>
                    <span class="text-petfy-accent text-xs font-semibold bg-petfy-accent/20 px-2 py-0.5 rounded ml-1">ADMIN</span>
                </a>
            </div>

            {{-- Links desktop --}}
            <div class="hidden md:flex items-center gap-0.5 text-sm">
                <a href="{{ route('admin.productos.index') }}"
                   class="px-3 py-1.5 rounded hover:bg-petfy/60 transition {{ request()->routeIs('admin.productos.*') ? 'bg-petfy/60' : '' }}">
                    <i class="fa-solid fa-box mr-1"></i>Productos
                </a>
                <a href="{{ route('admin.categorias.index') }}"
                   class="px-3 py-1.5 rounded hover:bg-petfy/60 transition {{ request()->routeIs('admin.categorias.*') ? 'bg-petfy/60' : '' }}">
                    <i class="fa-solid fa-tags mr-1"></i>Categorías
                </a>
                <a href="{{ route('admin.pedidos.index') }}"
                   class="px-3 py-1.5 rounded hover:bg-petfy/60 transition {{ request()->routeIs('admin.pedidos.*') ? 'bg-petfy/60' : '' }}">
                    <i class="fa-solid fa-clipboard-list mr-1"></i>Pedidos
                </a>
                <a href="{{ route('admin.usuarios.index') }}"
                   class="px-3 py-1.5 rounded hover:bg-petfy/60 transition {{ request()->routeIs('admin.usuarios.*') ? 'bg-petfy/60' : '' }}">
                    <i class="fa-solid fa-users mr-1"></i>Usuarios
                </a>
                <a href="{{ route('admin.reportes.index') }}"
                   class="px-3 py-1.5 rounded hover:bg-petfy/60 transition {{ request()->routeIs('admin.reportes.*') ? 'bg-petfy/60' : '' }}">
                    <i class="fa-solid fa-chart-bar mr-1"></i>Reportes
                </a>
            </div>

            {{-- Derecha: usuario + salir + hamburguesa --}}
            <div class="flex-1 flex items-center justify-end gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="hidden sm:inline text-sm text-white/70 hover:text-white transition">
                    {{ auth()->user()->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm px-3 py-1.5 rounded bg-white/10 hover:bg-white/20 transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>Salir
                    </button>
                </form>
                <button @click="open = !open"
                        class="md:hidden p-2 rounded hover:bg-white/10 transition"
                        aria-label="Menú">
                    <i class="fa-solid text-lg" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- Dropdown mobile admin --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         @click.outside="open = false"
         class="block md:hidden absolute w-full top-full bg-petfy-dark border-t border-white/10 shadow-lg z-50 py-2 px-3">

        <a href="{{ route('admin.productos.index') }}"  class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-box w-4 text-xs"></i>Productos</a>
        <a href="{{ route('admin.categorias.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-tags w-4 text-xs"></i>Categorías</a>
        <a href="{{ route('admin.pedidos.index') }}"    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-clipboard-list w-4 text-xs"></i>Pedidos</a>
        <a href="{{ route('admin.usuarios.index') }}"   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-users w-4 text-xs"></i>Usuarios</a>
        <a href="{{ route('admin.reportes.index') }}"   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-chart-bar w-4 text-xs"></i>Reportes</a>

        <div class="border-t border-white/10 my-1.5"></div>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm"><i class="fa-solid fa-user w-4 text-xs"></i>{{ auth()->user()->name }}</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy/60 transition text-sm text-left">
                <i class="fa-solid fa-right-from-bracket w-4 text-xs"></i>Salir
            </button>
        </form>

    </div>
</nav>

@else

{{-- ══════════════  NAV CLIENTE  ══════════════ --}}
<nav class="relative bg-gradient-to-r from-petfy-light to-petfy shadow-md"
     x-data="{ open: false }"
     @resize.window="if (window.innerWidth >= 768) open = false">

    <div class="relative max-w-7xl mx-auto px-4">
        <div class="flex items-center h-14">

            {{-- ① LOGO — izquierda --}}
            <div class="flex-1 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('img/Logo.png') }}" alt="PetFy"
                         class="h-9 w-9 rounded-full shadow object-cover">
                    <span class="text-white font-bold text-sm hidden sm:block">PetFy Pet Shop</span>
                </a>
            </div>

            {{-- ② LINKS — centro (solo desktop) --}}
            <div class="hidden md:flex items-center gap-0.5 text-white text-sm font-medium">
                <a href="{{ route('home') }}"     class="px-3 py-1.5 rounded-lg hover:bg-petfy-dark transition">Inicio</a>
                <a href="{{ url('/productos') }}" class="px-3 py-1.5 rounded-lg hover:bg-petfy-dark transition">Productos</a>
                <a href="{{ url('/nosotros') }}"  class="px-3 py-1.5 rounded-lg hover:bg-petfy-dark transition">Nosotros</a>
                <a href="{{ url('/contacto') }}"  class="px-3 py-1.5 rounded-lg hover:bg-petfy-dark transition">Contacto</a>
            </div>

            {{-- ③ ICONOS — derecha (solo desktop) --}}
            <div class="hidden md:flex flex-1 items-center justify-end gap-0.5 text-white">
                @guest
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-petfy-dark transition">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-petfy-accent text-petfy-dark text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cuenta') }}" class="p-2 rounded-lg hover:bg-petfy-dark transition"><i class="fa-solid fa-user"></i></a>
                @endguest
                @auth
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-petfy-dark transition">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-petfy-accent text-petfy-dark text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ url('/wishlist') }}" class="p-2 rounded-lg hover:bg-petfy-dark transition">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-1.5 px-2 py-1.5 rounded-lg hover:bg-petfy-dark transition text-sm">
                        <i class="fa-solid fa-user"></i>
                        <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-2 py-1.5 rounded-lg hover:bg-petfy-dark transition text-sm">Salir</button>
                    </form>
                @endauth
            </div>

            {{-- ④ MOBILE — carrito + hamburguesa --}}
            <div class="flex md:hidden items-center gap-1 text-white">
                <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-petfy-dark transition">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-petfy-accent text-petfy-dark text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>
                <button @click="open = !open" class="p-2 rounded-lg hover:bg-petfy-dark transition" aria-label="Menú">
                    <i class="fa-solid text-lg" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- DROPDOWN MOBILE cliente --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         @click.outside="open = false"
         class="block md:hidden absolute w-full top-full bg-petfy border-t border-petfy-dark/20 shadow-lg z-50 py-2 px-3">

        <a href="{{ route('home') }}"     class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-house w-4 text-xs"></i>Inicio</a>
        <a href="{{ url('/productos') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-paw w-4 text-xs"></i>Productos</a>
        <a href="{{ url('/nosotros') }}"  class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-store w-4 text-xs"></i>Nosotros</a>
        <a href="{{ url('/contacto') }}"  class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-envelope w-4 text-xs"></i>Contacto</a>

        <div class="border-t border-petfy-dark/20 my-1.5"></div>

        @guest
            <a href="{{ route('login') }}"    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-right-to-bracket w-4 text-xs"></i>Iniciar sesión</a>
            <a href="{{ route('register') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-user-plus w-4 text-xs"></i>Crear cuenta</a>
        @endguest
        @auth
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm"><i class="fa-solid fa-user w-4 text-xs"></i>{{ auth()->user()->name }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-petfy-dark transition text-white text-sm text-left"><i class="fa-solid fa-right-from-bracket w-4 text-xs"></i>Salir</button>
            </form>
        @endauth

    </div>
</nav>

@endif
