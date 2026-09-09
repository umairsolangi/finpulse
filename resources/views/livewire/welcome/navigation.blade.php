<nav class="flex items-center gap-4 justify-end">
    <a
        href="{{ route('learn.index') }}"
        wire:navigate
        class="px-4 py-2 text-finpulse-navy hover:text-finpulse-gold font-semibold text-sm transition-colors duration-200"
    >
        Learn
    </a>
    @auth
        <a
            href="{{ url('/dashboard') }}"
            wire:navigate
            class="px-5 py-2.5 bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-semibold text-sm rounded-lg transition-all duration-200 shadow-sm"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            wire:navigate
            class="px-4 py-2 text-finpulse-navy hover:text-finpulse-gold font-semibold text-sm transition-colors duration-200"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                wire:navigate
                class="px-5 py-2.5 bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-semibold text-sm rounded-lg transition-all duration-200 shadow-sm"
            >
                Get Started
            </a>
        @endif
    @endauth
</nav>
