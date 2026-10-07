<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-[#39E554] hover:bg-[#32d44b] text-slate-950 font-black text-sm rounded-xl transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#39E554] focus:ring-offset-2 disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>

