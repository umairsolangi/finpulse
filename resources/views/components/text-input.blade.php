@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-[#39E554] focus:ring-[#39E554] rounded-xl shadow-xs text-slate-900 placeholder-slate-400 focus:ring-2 text-sm transition-colors py-2.5 px-3.5']) }}>

