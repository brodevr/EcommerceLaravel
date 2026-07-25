@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de páginas" class="flex items-center justify-between">

        {{-- Mobile: solo Anterior / Siguiente --}}
        <div class="flex gap-2 items-center justify-between w-full sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-300 bg-white border border-slate-200 cursor-not-allowed rounded-lg">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-petfy bg-white border border-petfy-light rounded-lg hover:bg-petfy/10 transition">
                    ← Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-petfy bg-white border border-petfy-light rounded-lg hover:bg-petfy/10 transition">
                    Siguiente →
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-300 bg-white border border-slate-200 cursor-not-allowed rounded-lg">
                    Siguiente →
                </span>
            @endif

        </div>

        {{-- Desktop: info + números --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">

            <p class="text-sm text-slate-500">
                Mostrando
                @if ($paginator->firstItem())
                    <span class="font-semibold text-petfy-dark">{{ $paginator->firstItem() }}</span>
                    al
                    <span class="font-semibold text-petfy-dark">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                de
                <span class="font-semibold text-petfy-dark">{{ $paginator->total() }}</span>
                resultados
            </p>

            <div>
                <span class="inline-flex rounded-xl shadow-sm overflow-hidden border border-slate-200">

                    {{-- Botón anterior --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center px-3 py-2 text-slate-300 bg-white cursor-not-allowed border-r border-slate-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="inline-flex items-center px-3 py-2 text-petfy bg-white hover:bg-petfy/10 border-r border-slate-200 transition"
                           aria-label="Página anterior">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Números de página --}}
                    @foreach ($elements as $element)

                        @if (is_string($element))
                            <span class="inline-flex items-center px-4 py-2 text-sm text-slate-400 bg-white border-r border-slate-200 cursor-default select-none">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-petfy border-r border-petfy-dark/20 cursor-default select-none">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-600 bg-white hover:bg-petfy/10 hover:text-petfy border-r border-slate-200 transition"
                                       aria-label="Ir a página {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif

                    @endforeach

                    {{-- Botón siguiente --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="inline-flex items-center px-3 py-2 text-petfy bg-white hover:bg-petfy/10 transition"
                           aria-label="Página siguiente">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 text-slate-300 bg-white cursor-not-allowed">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                    @endif

                </span>
            </div>
        </div>

    </nav>
@endif
