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
    <!-- Premium Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GSAP for app animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Observer.min.js"></script>
</head>

<body
    class="antialiased bg-[#F2F6F3] text-slate-700 selection:bg-[#39E554] selection:text-slate-950 min-h-screen"
    style="font-family:'Plus Jakarta Sans',sans-serif;"
    x-data="{ sideOpen: false }">
    <div class="min-h-screen flex">
        <!-- Desktop Sidebar Navigation -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 z-30 shadow-xl" style="background:#061a14;">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 h-16 shrink-0" style="border-bottom:1px solid rgba(255,255,255,0.07);">
                <a href="/" wire:navigate class="flex items-center gap-3 group">
                    <div class="h-9 w-9 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300"
                        style="background:linear-gradient(135deg,#39E554,#28a04a);box-shadow:0 4px 14px rgba(57,229,84,0.4);">
                        <span class="text-slate-950 font-black text-sm">FP</span>
                    </div>
                    <span class="font-black text-lg text-white tracking-tight" style="font-family:'Plus Jakarta Sans',sans-serif;">Fin<span class="text-[#39E554]">Pulse</span></span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
                <p class="px-3 mb-2 text-[9px] font-black uppercase tracking-[0.18em] text-white/25">Platform</p>
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('learn.*') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                    style="{{ request()->routeIs('learn.*') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Learn
                </a>
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('courses.*') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                    style="{{ request()->routeIs('courses.*') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Courses
                </a>
                <a href="{{ route('research.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('research.*') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                    style="{{ request()->routeIs('research.*') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Research
                </a>
                <a href="{{ route('live-sessions.index') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('live-sessions.*') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                    style="{{ request()->routeIs('live-sessions.*') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Live Sessions
                </a>
                <a href="{{ route('pricing') }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('pricing') ? 'text-[#39E554]' : 'text-[#39E554]/70 hover:text-[#39E554] hover:bg-white/5' }}"
                    style="{{ request()->routeIs('pricing') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.15),rgba(40,160,74,0.08));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pricing &amp; Plans
                </a>

                <p class="px-3 mt-4 mb-2 text-[9px] font-black uppercase tracking-[0.18em] text-white/25">Account</p>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                        style="{{ request()->routeIs('dashboard') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('feed') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('feed') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                        style="{{ request()->routeIs('feed') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Feed
                    </a>
                    <a href="{{ route('leaderboard') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('leaderboard') ? 'text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}"
                        style="{{ request()->routeIs('leaderboard') ? 'background:linear-gradient(135deg,rgba(57,229,84,0.18),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.25);' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Leaderboard
                    </a>
                @endauth
            </nav>

            <!-- User Section -->
            <div class="px-3 py-4" style="border-top:1px solid rgba(255,255,255,0.07);">
                @auth
                    <div class="flex items-center gap-3 px-2 py-2 rounded-xl" style="background:rgba(255,255,255,0.04);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-sm shrink-0 text-slate-950"
                            style="background:linear-gradient(135deg,#39E554,#28a04a);box-shadow:0 3px 10px rgba(57,229,84,0.35);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-white/35 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-2 flex gap-2">
                        <a href="{{ route('profile') }}" wire:navigate
                            class="flex-1 text-center px-3 py-1.5 text-xs font-bold text-white/50 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full text-center px-3 py-1.5 text-xs font-bold text-white/50 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" wire:navigate
                            class="flex-1 text-center px-3 py-2 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="flex-1 text-center px-3 py-2 text-xs font-semibold text-slate-950 bg-[#39E554] hover:bg-[#32d44b] rounded-lg transition-all">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 inset-x-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 text-slate-900"
            id="mobile-nav">
            <div class="flex items-center justify-between h-14 px-4">
                <a href="/" wire:navigate class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-[#39E554] flex items-center justify-center">
                        <span class="text-slate-950 font-black text-xs">FP</span>
                    </div>
                    <span class="font-bold text-sm text-slate-900">Fin<span class="text-[#28a04a]">Pulse</span></span>
                </a>
                <div class="flex items-center gap-2">
                    @auth
                        <livewire:notification-bell />
                    @endauth
                    <button @click="sideOpen = !sideOpen" class="p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5 text-slate-700"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!sideOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="sideOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
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
            class="lg:hidden fixed inset-y-0 left-0 w-72 bg-[#061a14] text-white z-50 flex flex-col" x-cloak>
            <div class="flex items-center justify-between px-6 h-14 border-b border-white/10">
                <span class="font-bold text-lg text-white">Fin<span class="text-[#39E554]">Pulse</span></span>
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
                <a href="{{ route('courses.index') }}" wire:navigate @click="sideOpen = false"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('courses.*') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Courses
                </a>
                <a href="{{ route('research.index') }}" wire:navigate @click="sideOpen = false"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('research.*') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Research
                </a>
                <a href="{{ route('live-sessions.index') }}" wire:navigate @click="sideOpen = false"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('live-sessions.*') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Live Sessions
                </a>
                <a href="{{ route('pricing') }}" wire:navigate @click="sideOpen = false"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('pricing') ? 'bg-[#39E554]/15 text-[#39E554]' : 'text-[#39E554] hover:text-[#32d44b] hover:bg-white/5' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pricing & Plans
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
                            class="w-9 h-9 rounded-full bg-[#39E554] text-slate-950 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/40 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('profile') }}" wire:navigate @click="sideOpen = false"
                            class="flex-1 text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full text-center px-3 py-1.5 text-xs font-semibold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                                Log Out
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen">
            <!-- Desktop Top Bar -->
            <div class="hidden lg:block sticky top-0 z-20 fp-nav-glass border-b border-slate-200/80"
                id="top-bar">
                <div class="flex items-center justify-between h-14 px-8">
                    <div></div>
                    <div class="flex items-center gap-4">
                        @auth
                            <livewire:notification-bell />
                            <span class="text-sm text-slate-500">Welcome back, <strong
                                    class="text-slate-900">{{ auth()->user()->name }}</strong></span>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="fp-page-enter pt-14 lg:pt-0">
                @if (isset($header))
                    <header class="bg-white border-b border-slate-200/80">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}

                <!-- Global Compliance & Legal Footer -->
                <footer class="mt-16 border-t border-slate-200/60 bg-white/80 backdrop-blur-sm py-8 px-4 sm:px-6 lg:px-8 text-xs text-slate-500">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900">Fin<span class="text-[#28a04a]">Pulse</span></span>
                            <span class="text-slate-300">•</span>
                            <span>Financial Literacy & Research Platform</span>
                        </div>
                        <div class="flex items-center gap-4 flex-wrap">
                            <a href="{{ route('pricing') }}" wire:navigate
                                class="hover:text-slate-900 font-semibold transition-colors">Pricing</a>
                            <a href="{{ route('terms') }}" wire:navigate
                                class="hover:text-slate-900 transition-colors">Terms of Service</a>
                            <a href="{{ route('privacy') }}" wire:navigate
                                class="hover:text-slate-900 transition-colors">Privacy Policy</a>
                            <a href="{{ route('refund-policy') }}" wire:navigate
                                class="hover:text-slate-900 transition-colors">Refund & Cancellation</a>
                        </div>
                    </div>
                    <div class="max-w-7xl mx-auto mt-4 pt-4 border-t border-slate-100 text-[11px] text-slate-400 text-center sm:text-left leading-relaxed">
                        Disclaimer: FinPulse is an educational platform. Market analyses and valuation frameworks are
                        provided solely for financial literacy and do not constitute registered investment advice.
                    </div>
                </footer>
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

    <!-- Scroll Progress Laser Bar -->
    <div id="fp-scroll-progress" class="fp-scroll-progress" style="width: 0%;"></div>

    <!-- Futuristic Custom Cursor Elements (Desktop Only) -->
    <div id="fp-cursor-glow" class="fp-cursor-glow" aria-hidden="true"></div>
    <div id="fp-cursor-ring" class="fp-cursor-ring" aria-hidden="true"></div>
    <div id="fp-cursor-dot" class="fp-cursor-dot" aria-hidden="true"></div>

    <!-- Floating Back to Top Button with Circular Progress -->
    <button id="fp-back-to-top" class="fp-back-to-top" aria-label="Back to top" title="Back to top">
        <svg class="fp-progress-circle" width="46" height="46" viewBox="0 0 46 46">
            <circle class="fp-progress-bg" cx="23" cy="23" r="19" fill="none" stroke-width="2.5" />
            <circle id="fp-progress-bar" class="fp-progress-bar" cx="23" cy="23" r="19" fill="none" stroke-width="2.5" stroke-dasharray="119.38" stroke-dashoffset="119.38" />
        </svg>
        <svg class="w-4 h-4 text-[#39E554] fp-arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- App-wide Advanced Scroll & Interactive Cursor Script -->
    <script>
        (function() {
            let cursorInitialized = false;
            let currentCtx = null;
            let quickDotX, quickDotY, quickRingX, quickRingY, quickGlowX, quickGlowY;

            function setupInteractiveCursor() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                const isDesktop = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
                if (!isDesktop) return;

                const dot = document.getElementById('fp-cursor-dot');
                const ring = document.getElementById('fp-cursor-ring');
                const glow = document.getElementById('fp-cursor-glow');
                if (!dot || !ring || !glow) return;

                if (!cursorInitialized) {
                    cursorInitialized = true;

                    // GSAP quickTo setters for buttery 60fps interpolation
                    quickDotX = gsap.quickTo(dot, 'left', { duration: 0.08, ease: 'power3.out' });
                    quickDotY = gsap.quickTo(dot, 'top', { duration: 0.08, ease: 'power3.out' });
                    quickRingX = gsap.quickTo(ring, 'left', { duration: 0.22, ease: 'power2.out' });
                    quickRingY = gsap.quickTo(ring, 'top', { duration: 0.22, ease: 'power2.out' });
                    quickGlowX = gsap.quickTo(glow, 'left', { duration: 0.45, ease: 'power2.out' });
                    quickGlowY = gsap.quickTo(glow, 'top', { duration: 0.45, ease: 'power2.out' });

                    window.addEventListener('mousemove', (e) => {
                        const x = e.clientX;
                        const y = e.clientY;

                        quickDotX(x);
                        quickDotY(y);
                        quickRingX(x);
                        quickRingY(y);
                        quickGlowX(x);
                        quickGlowY(y);

                        if (!dot.classList.contains('active')) {
                            dot.classList.add('active');
                            ring.classList.add('active');
                            glow.classList.add('active');
                        }

                        // Update spotlight variables on hovered cards
                        const targetCard = e.target.closest('.stat-card, .action-card, .welcome-card, .upgrade-card, .fp-card-spotlight');
                        if (targetCard) {
                            const rect = targetCard.getBoundingClientRect();
                            targetCard.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                            targetCard.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                        }
                    }, { passive: true });

                    document.addEventListener('mouseleave', () => {
                        dot.classList.remove('active');
                        ring.classList.remove('active');
                        glow.classList.remove('active');
                    });

                    document.addEventListener('mouseenter', () => {
                        dot.classList.add('active');
                        ring.classList.add('active');
                        glow.classList.add('active');
                    });

                    window.addEventListener('mousedown', () => {
                        ring.classList.add('clicking');
                        dot.classList.add('clicking');
                    });

                    window.addEventListener('mouseup', () => {
                        ring.classList.remove('clicking');
                        dot.classList.remove('clicking');
                    });
                }

                // Bind hover state listeners for interactive elements (supports dynamic Livewire DOM updates)
                const interactiveSelector = 'a, button, input, select, textarea, [role="button"], .stat-card, .action-card, .upgrade-card, .fp-interactive, .fp-tilt-card';
                document.querySelectorAll(interactiveSelector).forEach((el) => {
                    if (el.dataset.fpCursorBound) return;
                    el.dataset.fpCursorBound = 'true';

                    el.addEventListener('mouseenter', () => {
                        ring.classList.add('hovering');
                        dot.classList.add('hovering');
                    });
                    el.addEventListener('mouseleave', () => {
                        ring.classList.remove('hovering');
                        dot.classList.remove('hovering');
                    });
                });
            }

            function setup3DTiltCards() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                const isDesktop = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
                if (!isDesktop) return;

                const tiltCards = document.querySelectorAll('.fp-tilt-card, .stat-card, .action-card, .upgrade-card');
                tiltCards.forEach((card) => {
                    if (card.dataset.fpTiltBound) return;
                    card.dataset.fpTiltBound = 'true';

                    const tiltRotateX = gsap.quickTo(card, 'rotateX', { duration: 0.35, ease: 'power2.out' });
                    const tiltRotateY = gsap.quickTo(card, 'rotateY', { duration: 0.35, ease: 'power2.out' });
                    const tiltScale = gsap.quickTo(card, 'scale', { duration: 0.35, ease: 'power2.out' });

                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const cx = rect.left + rect.width / 2;
                        const cy = rect.top + rect.height / 2;
                        const dx = (e.clientX - cx) / (rect.width / 2);
                        const dy = (e.clientY - cy) / (rect.height / 2);
                        const maxAngle = 6.5;

                        gsap.set(card, { transformPerspective: 800, transformStyle: 'preserve-3d' });
                        tiltRotateX(-dy * maxAngle);
                        tiltRotateY(dx * maxAngle);
                        tiltScale(1.02);
                    });

                    card.addEventListener('mouseleave', () => {
                        tiltRotateX(0);
                        tiltRotateY(0);
                        tiltScale(1);
                    });
                });
            }

            function setupScrollEffects() {
                const progressBar = document.getElementById('fp-scroll-progress');
                const backToTopBtn = document.getElementById('fp-back-to-top');
                const progressCircleBar = document.getElementById('fp-progress-bar');
                const topBar = document.getElementById('top-bar');

                const circleCircumference = 119.38; // 2 * PI * 19

                const updateScroll = () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
                    const pct = maxScroll > 0 ? Math.min(100, Math.max(0, (scrollTop / maxScroll) * 100)) : 0;

                    if (progressBar) {
                        progressBar.style.width = pct + '%';
                    }

                    if (progressCircleBar) {
                        const offset = circleCircumference - (pct / 100) * circleCircumference;
                        progressCircleBar.style.strokeDashoffset = offset;
                    }

                    if (backToTopBtn) {
                        if (scrollTop > 240) {
                            backToTopBtn.classList.add('visible');
                        } else {
                            backToTopBtn.classList.remove('visible');
                        }
                    }

                    if (topBar) {
                        if (scrollTop > 20) {
                            topBar.classList.add('shadow-sm', 'bg-white/95');
                            topBar.classList.remove('bg-white/70');
                        } else {
                            topBar.classList.remove('shadow-sm', 'bg-white/95');
                            topBar.classList.add('bg-white/70');
                        }
                    }
                };

                window.addEventListener('scroll', updateScroll, { passive: true });
                updateScroll();

                if (backToTopBtn && !backToTopBtn.dataset.bound) {
                    backToTopBtn.dataset.bound = 'true';
                    backToTopBtn.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }
            }

            function setupGsapAnimations() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

                gsap.registerPlugin(ScrollTrigger);
                if (typeof Observer !== 'undefined') {
                    gsap.registerPlugin(Observer);
                }

                if (currentCtx) {
                    currentCtx.revert();
                }

                currentCtx = gsap.context(() => {
                    // Staggered cards and sections on scroll
                    ScrollTrigger.batch('.fp-animate-in', {
                        start: 'top 92%',
                        once: true,
                        onEnter: (batch) => {
                            gsap.fromTo(batch,
                                { opacity: 0, y: 32, scale: 0.98 },
                                {
                                    opacity: 1, y: 0, scale: 1,
                                    duration: 0.65,
                                    stagger: 0.08,
                                    ease: 'power3.out',
                                    overwrite: true,
                                }
                            );
                        },
                    });

                    // Stagger grid items
                    ScrollTrigger.batch('.fp-stagger-grid > *', {
                        start: 'top 90%',
                        once: true,
                        onEnter: (batch) => {
                            gsap.fromTo(batch,
                                { opacity: 0, y: 36, scale: 0.96 },
                                {
                                    opacity: 1, y: 0, scale: 1,
                                    duration: 0.55,
                                    stagger: 0.07,
                                    ease: 'power3.out',
                                    overwrite: true,
                                }
                            );
                        },
                    });

                    // Subtle parallax on welcome card background blobs
                    if (document.querySelector('.fp-parallax-blob-1')) {
                        gsap.to('.fp-parallax-blob-1', {
                            y: -45,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: '.welcome-card',
                                start: 'top bottom',
                                end: 'bottom top',
                                scrub: 1.2,
                            },
                        });
                    }

                    if (document.querySelector('.fp-parallax-blob-2')) {
                        gsap.to('.fp-parallax-blob-2', {
                            y: 35,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: '.welcome-card',
                                start: 'top bottom',
                                end: 'bottom top',
                                scrub: 1.2,
                            },
                        });
                    }

                    // Desktop top bar auto-hide on scroll direction
                    const topBar = document.getElementById('top-bar');
                    if (topBar && window.innerWidth >= 1024 && typeof Observer !== 'undefined') {
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
                });

                ScrollTrigger.refresh();
            }

            function initAll() {
                setupInteractiveCursor();
                setup3DTiltCards();
                setupScrollEffects();
                setupGsapAnimations();
            }

            document.addEventListener('DOMContentLoaded', initAll);
            document.addEventListener('livewire:navigated', () => {
                setTimeout(initAll, 50);
            });
        })();
    </script>
</body>

</html>