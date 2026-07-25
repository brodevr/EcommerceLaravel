@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border border-[#b2ebf2] rounded-[0.7rem] px-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-petfy focus:ring-2 focus:ring-petfy/25 focus:outline-none transition duration-150']) }}>
