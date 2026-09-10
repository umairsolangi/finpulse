<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FinPulse') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GSAP for app animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Observer.min.js"></script>
</head>

<body class="font-sans antialiased {{ request()->routeIs('dashboard') ? 'bg-[#050c2c] text-[#b6c0e7] selection:bg-[#4e5bff] selection:text-white' : 'bg-[#F8FAFE] text-[#4A5A72] selection:bg-[#0B1A33] selection:text-white' }} min-h-screen" x-data="{ sideOpen: false }">
    <div class="min-h-screen flex">
        <!-- Desktop Sidebar Navigation -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 bg-[#0B1A33] text-white z-30 shadow-lg">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 h-16 shrink-0 border-b border-white/10">
                <a href="/" wire:navigate class="flex items-center gap-3 group">
                    <div
                        class="h-9 w-9 rounded-full border-2 border-white/30 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300 bg-[#0B1A33]">
                        <span class="text-white font-black text-sm">FP</span>
                    </div>
                    <span class="font-bold text-lg text-white">Fin<span class="text-[#C89B3C]">Pulse</span></span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('learn.*') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Learn
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('feed') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('feed') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Feed
                    </a>
                    <a href="{{ route('leaderboard') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('leaderboard') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Leaderboard
                    </a>
                @endauth
            </nav>

            <!-- User Section -->
            <div class="px-4 py-4 border-t border-white/10">
                @auth
                    <div class="flex items-center gap-3 px-2">
                        <div
                            class="w-9 h-9 rounded-full bg-[#C89B3C] text-[#0B1A33] flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/40 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('profile') }}" wire:navigate
                            class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                            Profile
                        </a>
                        <button wire:click="logout"
                            class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                            Log Out
                        </button>
                    </div>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" wire:navigate
                            class="flex-1 text-center px-3 py-2 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="flex-1 text-center px-3 py-2 text-xs font-semibold text-[#0B1A33] bg-[#C89B3C] hover:bg-[#d4a942] rounded-lg transition-all">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 inset-x-0 z-40 {{ request()->routeIs('dashboard') ? 'bg-[#07113d]/90 border-b border-[#889eff]/20 text-white' : 'fp-nav-glass text-[#0B1A33]' }}" id="mobile-nav">
            <div class="flex items-center justify-between h-14 px-4">
                <a href="/" wire:navigate class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-[#0B1A33] flex items-center justify-center">
                        <span class="text-white font-black text-xs">FP</span>
                    </div>
                    <span class="font-bold text-sm {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#0B1A33]' }}">Fin<span class="text-[#C89B3C]">Pulse</span></span>
                </a>
                <button @click="sideOpen = !sideOpen" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[#0B1A33]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!sideOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="sideOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sideOpen" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sideOpen = false"
            class="lg:hidden fixed inset-0 bg-black/50 z-40" x-cloak></div>

        <!-- Mobile Sidebar -->
        <div x-show="sideOpen" x-transition:enter="transition-transform duration-300 ease-out"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform duration-200 ease-in" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="lg:hidden fixed inset-y-0 left-0 w-72 bg-[#0B1A33] text-white z-50 flex flex-col" x-cloak>
            <div class="flex items-center justify-between px-6 h-14 border-b border-white/10">
                <span class="font-bold text-lg text-white">Fin<span class="text-[#C89B3C]">Pulse</span></span>
                <button @click="sideOpen = false" class="p-1 rounded hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1">
                <a href="{{ route('learn.index') }}" wire:navigate @click="sideOpen = false"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('learn.*') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Learn
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate @click="sideOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('feed') }}" wire:navigate @click="sideOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('feed') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Feed
                    </a>
                    <a href="{{ route('leaderboard') }}" wire:navigate @click="sideOpen = false"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('leaderboard') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Leaderboard
                    </a>
                @endauth
            </nav>
            <div class="px-4 py-4 border-t border-white/10">
                @auth
                    <div class="flex items-center gap-3 px-2 mb-3">
                        <div
                            class="w-9 h-9 rounded-full bg-[#C89B3C] text-[#0B1A33] flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/40 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('profile') }}" wire:navigate @click="sideOpen = false"
                            class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">Profile</a>
                        <button wire:click="logout"
                            class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">Log
                            Out</button>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen">
            <!-- Desktop Top Bar -->
            <div class="hidden lg:block sticky top-0 z-20 {{ request()->routeIs('dashboard') ? 'bg-[#07113d]/80 border-b border-[#889eff]/20 backdrop-blur-xl text-[#f7f8ff]' : 'fp-nav-glass border-b border-gray-100/80' }}" id="top-bar">
                <div class="flex items-center justify-between h-14 px-8">
                    <div></div>
                    <div class="flex items-center gap-4">
                        @auth
                            @if(request()->routeIs('dashboard'))
                                <span class="text-sm text-[#b6c0e7]">Welcome back, <strong class="text-[#6d80ff]">{{ auth()->user()->name }}</strong></span>
                            @else
                                <span class="text-sm text-gray-500">Welcome back, <strong class="text-[#0B1A33]">{{ auth()->user()->name }}</strong></span>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="fp-page-enter pt-14 lg:pt-0">
                @if (isset($header))
                    <header class="{{ request()->routeIs('dashboard') ? 'bg-[#07113d]/60 border-b border-[#889eff]/20 backdrop-blur-xl text-white' : 'bg-white border-b border-gray-100' }}">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Global Badge Earned Toast Notification -->
    <div x-data="{ show: false, badge: '', message: '' }"
        @badge-earned.window="badge = $event.detail.badge; message = 'You earned the ' + badge + ' badge!'; show = true; setTimeout(() => show = false, 5000)"
        x-show="show" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white rounded-2xl shadow-2xl border border-amber-300/80 p-4 flex items-center gap-3 overflow-hidden"
        style="display: none;" x-cloak>
        <div
            class="w-11 h-11 rounded-xl bg-amber-500/15 border border-amber-300 flex items-center justify-center text-2xl shrink-0 text-amber-600 animate-bounce">
            🏆
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-amber-800">Badge Unlocked!</p>
            <p class="text-sm font-bold text-finpulse-navy truncate" x-text="message"></p>
        </div>
        <button @click="show = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg text-lg leading-none">
            &times;
        </button>
    </div>

    <!-- App-wide scroll animation script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
            gsap.registerPlugin(ScrollTrigger, Observer);

            // ============================================================
            // GSAP CONTEXT — Livewire-safe cleanup
            // ============================================================
            const ctx = gsap.context(() => {

                // Animate all cards and sections on scroll using batch
                ScrollTrigger.batch('.fp-animate-in', {
                    start: 'top 90%',
                    once: true,
                    onEnter: (batch) => {
                        gsap.fromTo(batch,
                            { opacity: 0, y: 30 },
                            {
                                opacity: 1, y: 0,
                                duration: 0.6,
                                stagger: 0.06,
                                ease: 'power3.out',
                                overwrite: true,
                            }
                        );
                    },
                });

                // Stagger cards in grids using batch
                ScrollTrigger.batch('.fp-stagger-grid > *', {
                    start: 'top 88%',
                    once: true,
                    onEnter: (batch) => {
                        gsap.fromTo(batch,
                            { opacity: 0, y: 40, scale: 0.95 },
                            {
                                opacity: 1, y: 0, scale: 1,
                                duration: 0.5,
                                stagger: 0.08,
                                ease: 'power3.out',
                                overwrite: true,
                            }
                        );
                    },
                });

                // ============================================================
                // OBSERVER — Desktop top bar auto-hide on scroll direction
                // ============================================================
                const topBar = document.getElementById('top-bar');
                if (topBar && window.innerWidth >= 1024) {
                    let lastScrollTop = 0;
                    let ticking = false;

                    Observer.create({
                        type: 'scroll',
                        onUp: () => {
                            if (!ticking) {
                                requestAnimationFrame(() => {
                                    const st = window.pageYOffset;
                                    if (st > lastScrollTop && st > 100) {
                                        topBar.classList.add('fp-nav-hidden');
                                        topBar.classList.remove('fp-nav-visible');
                                    }
                                    lastScrollTop = st <= 0 ? 0 : st;
                                    ticking = false;
                                });
                                ticking = true;
                            }
                        },
                        onDown: () => {
                            if (!ticking) {
                                requestAnimationFrame(() => {
                                    const st = window.pageYOffset;
                                    if (st < lastScrollTop) {
                                        topBar.classList.remove('fp-nav-hidden');
                                        topBar.classList.add('fp-nav-visible');
                                    }
                                    lastScrollTop = st <= 0 ? 0 : st;
                                    ticking = false;
                                });
                                ticking = true;
                            }
                        },
                        wheel: true,
                        touch: true,
                    });
                }

                // ============================================================
                // MATCHMEDIA — Responsive animations
                // ============================================================
                const mm = gsap.matchMedia();

                mm.add('(min-width: 1024px)', () => {
                    // Desktop-only animations here
                    return () => { };
                });

                mm.add('(max-width: 767px)', () => {
                    // Mobile-only animations here
                    return () => { };
                });

            }); // end gsap.context
        });
    </script>
</body>

</html>