@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-finpulse-gray']) }}>
    {{ $value ?? $slot }}
</label>
