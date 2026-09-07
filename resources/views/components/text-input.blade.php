@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-finpulse-gold focus:ring-finpulse-gold rounded-lg shadow-sm text-gray-900 placeholder-gray-400 focus:ring-1']) }}>

