<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-semibold text-sm rounded-lg transition-all duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-finpulse-gold focus:ring-offset-2 disabled:opacity-50']) }}>
    {{ $slot }}
</button>

