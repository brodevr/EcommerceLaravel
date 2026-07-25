<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ config('app.name', 'PetFy') }} | @yield('title', 'Panel')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 flex flex-col">

    {{-- Barra admin --}}
    <nav class="bg-petfy-dark text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg">
                    <img src="{{ asset('img/Logo.png') }}" class="h-8 w-8 rounded-full object-cover">
                    <span class="hidden sm:inline">PetFy</span>
                    <span class="text-petfy-accent text-xs font-semibold bg-petfy-accent/20 px-2 py-0.5 rounded ml-1">ADMIN</span>
                </a>
                <div class="hidden md:flex items-center gap-1 text-sm">
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
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-white/70 hidden sm:inline">
                    {{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm px-3 py-1.5 rounded bg-white/10 hover:bg-white/20 transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-8">

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
