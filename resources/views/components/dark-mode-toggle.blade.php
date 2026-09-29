{{-- Dark Mode Toggle Component
     Uses localStorage for persistence & Alpine.js for reactivity.
     Works with Tailwind's class-based dark mode.
--}}
<div x-data="{
        darkMode: localStorage.getItem('finpulse_dark_mode') === 'true',
        init() {
            this.applyMode();
            this.$watch('darkMode', () => this.applyMode());
        },
        toggle() {
            this.darkMode = !this.darkMode;
        },
        applyMode() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('finpulse_dark_mode', this.darkMode);
        }
     }">
    <button @click="toggle()"
        class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl transition-all duration-300 cursor-pointer group"
        :class="darkMode
            ? 'bg-slate-700/60 hover:bg-slate-600/80 border border-slate-600'
            : 'bg-white/80 hover:bg-white border border-slate-200 hover:border-[#39E554]/50'"
        title="Toggle dark mode"
        id="dark-mode-toggle"
        aria-label="Toggle dark mode">

        {{-- Sun icon (shown in dark mode → click to go light) --}}
        <svg x-show="darkMode" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 rotate-[-45deg] scale-75"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>

        {{-- Moon icon (shown in light mode → click to go dark) --}}
        <svg x-show="!darkMode" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 rotate-45 scale-75"
             x-transition:enter-end="opacity-100 rotate-0 scale-100"
             class="w-4 h-4 text-slate-600 group-hover:text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>
</div>
