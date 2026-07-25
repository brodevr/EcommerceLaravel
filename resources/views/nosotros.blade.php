@extends('layouts.petfy')

@section('title', 'Nosotros')

@section('content')

    {{-- HERO --}}
    <section class="relative h-[60vh] min-h-[400px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
             style="background-image: url('{{ asset('img/banner.jpg') }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-petfy-dark/80 to-petfy-light/60"></div>

        <div class="relative z-10 text-center max-w-3xl px-8">
            <h1 class="text-4xl sm:text-5xl font-bold text-white tracking-tight mb-4 drop-shadow">
                Sobre Nosotros
            </h1>
            <p class="text-lg sm:text-xl text-white italic drop-shadow">
                Un mundo hecho para ellos… y pensado para vos
            </p>
        </div>
    </section>

    {{-- CONTENIDO PRINCIPAL --}}
    <section class="bg-slate-50 py-16">
        <div class="max-w-6xl mx-auto px-6 space-y-12">

            {{-- Introducción --}}
            <div class="grid md:grid-cols-2 gap-12 items-center bg-white rounded-3xl shadow-lg p-8 sm:p-12
                        hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <div>
                    <h2 class="flex items-center gap-3 text-2xl sm:text-3xl font-semibold text-petfy mb-5">
                        <i class="fa-solid fa-heart text-petfy-light text-3xl"></i>
                        Nuestra Filosofía
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        En Petfy creemos que cada mascota merece una vida llena de bienestar, diversión y cariño.
                        No somos solo una petshop: somos un lugar donde las familias encuentran todo lo que necesitan
                        para cuidar a quienes más los acompañan cada día.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('img/Main.jpg') }}" alt="Mascotas felices"
                         class="w-full h-72 object-cover rounded-2xl shadow-lg hover:scale-[1.02] transition duration-300">
                </div>
            </div>

            {{-- Productos y cuidado (imagen a la izquierda) --}}
            <div class="grid md:grid-cols-2 gap-12 items-center bg-white rounded-3xl shadow-lg p-8 sm:p-12
                        hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <div class="md:order-1">
                    <img src="{{ asset('img/Comida-Perro.jpg') }}" alt="Productos de calidad"
                         class="w-full h-72 object-cover rounded-2xl shadow-lg hover:scale-[1.02] transition duration-300">
                </div>
                <div class="md:order-2">
                    <h2 class="flex items-center gap-3 text-2xl sm:text-3xl font-semibold text-petfy mb-5">
                        <i class="fa-solid fa-star text-petfy-light text-3xl"></i>
                        Calidad en Cada Producto
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        Desde alimentos de alta calidad y accesorios duraderos, hasta juguetes pensados para
                        estimular y hacer feliz a tu compañero, en Petfy seleccionamos cada producto con atención
                        y responsabilidad. Sabemos que detrás de cada compra hay una historia: un perro que mueve
                        la cola cuando llega su snack favorito, un gato curioso que necesita un rascador nuevo,
                        un cachorro que está creciendo y aprende del mundo a cada paso.
                    </p>
                </div>
            </div>

            {{-- Equipo y servicio --}}
            <div class="grid md:grid-cols-2 gap-12 items-center bg-white rounded-3xl shadow-lg p-8 sm:p-12
                        hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <div>
                    <h2 class="flex items-center gap-3 text-2xl sm:text-3xl font-semibold text-petfy mb-5">
                        <i class="fa-solid fa-users text-petfy-light text-3xl"></i>
                        Nuestro Compromiso
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        Nuestro equipo ama a los animales y trabaja para brindar una experiencia cercana, amable
                        y confiable. Te asesoramos, te acompañamos y te ayudamos a elegir lo mejor para tu mascota
                        según su edad, estilo de vida y necesidades.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('img/Imagen-Navbar.jpg') }}" alt="Cuidado profesional"
                         class="w-full h-72 object-cover rounded-2xl shadow-lg hover:scale-[1.02] transition duration-300">
                </div>
            </div>

            {{-- Valores (imagen a la izquierda) --}}
            <div class="grid md:grid-cols-2 gap-12 items-center bg-white rounded-3xl shadow-lg p-8 sm:p-12
                        hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <div class="md:order-1">
                    <img src="{{ asset('img/Cama-Mascotas.jpg') }}" alt="Comodidad para mascotas"
                         class="w-full h-72 object-cover rounded-2xl shadow-lg hover:scale-[1.02] transition duration-300">
                </div>
                <div class="md:order-2">
                    <h2 class="flex items-center gap-3 text-2xl sm:text-3xl font-semibold text-petfy mb-5">
                        <i class="fa-solid fa-house text-petfy-light text-3xl"></i>
                        Como Familia
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-6">
                        En Petfy, cuidamos a las mascotas como parte de nuestra propia familia. Queremos que cada
                        visita sea un momento especial, y que encuentres siempre variedad, calidad y precios justos.
                    </p>
                    <p class="bg-gradient-to-br from-petfy-light/20 to-petfy-light/40 border-l-4 border-petfy
                              rounded-xl p-6 text-center text-lg">
                        <strong class="text-petfy">Petfy: un mundo hecho para ellos… y pensado para vos.</strong>
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- VALORES --}}
    <section class="bg-gradient-to-br from-petfy-light/20 to-slate-50 py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl sm:text-4xl font-semibold text-petfy mb-12">¿Por qué elegir Petfy?</h2>

            <div class="grid sm:grid-cols-2 gap-8">
                @foreach ([
                    ['fa-award', 'Calidad Garantizada', 'Seleccionamos cada producto con atención y responsabilidad para garantizar la mejor calidad.'],
                    ['fa-handshake', 'Asesoramiento Personalizado', 'Te ayudamos a elegir lo mejor según la edad, estilo de vida y necesidades de tu mascota.'],
                    ['fa-heart', 'Amor por los Animales', 'Nuestro equipo ama a los animales y trabaja para brindar una experiencia cercana y confiable.'],
                    ['fa-dollar-sign', 'Precios Justos', 'Ofrecemos variedad, calidad y precios justos para que puedas cuidar mejor a tu compañero.'],
                ] as [$icono, $titulo, $texto])
                    <div class="bg-white rounded-2xl shadow p-8 hover:-translate-y-2 hover:shadow-lg transition duration-300">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-petfy-light to-petfy
                                    flex items-center justify-center shadow-md">
                            <i class="fa-solid {{ $icono }} text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-petfy mb-2">{{ $titulo }}</h3>
                        <p class="text-slate-600">{{ $texto }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection