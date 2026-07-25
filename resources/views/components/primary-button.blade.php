<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-petfy to-petfy-light hover:from-petfy-light hover:to-petfy border-0 rounded-[0.7rem] font-bold text-sm text-white tracking-wide shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-petfy/40 focus:ring-offset-2 transition-all duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>
