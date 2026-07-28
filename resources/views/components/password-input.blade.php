@props(['disabled' => false])

<div class="relative" x-data="{ show: false }">
    <input @disabled($disabled)
           :type="show ? 'text' : 'password'"
           {{ $attributes->merge(['class' => 'w-full border border-[#b2ebf2] rounded-[0.7rem] px-4 py-2.5 pr-11 text-slate-800 placeholder-slate-400 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition duration-150']) }}>

    <button type="button"
            @click="show = !show"
            tabindex="-1"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-petfy transition"
            :aria-label="show ? 'Ocultar contraseña' : 'Mostrar contraseña'">
        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
    </button>
</div>
