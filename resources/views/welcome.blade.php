<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>FinPulse  Learn. Track. Invest.</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Keyframe Animations */
            @keyframes pulseLineDraw {
                from { stroke-dashoffset: 600; }
                to { stroke-dashoffset: 0; }
            }

            @keyframes heartbeatPulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.03); }
            }

            @keyframes bounceGentle {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(6px); }
            }

            @keyframes badgeGlow {
                0%, 100% { opacity: 0.7; }
                50% { opacity: 1; }
            }

            .animate-line-draw {
                stroke-dasharray: 600;
                stroke-dashoffset: 600;
                animation: pulseLineDraw 1.2s ease-out forwards, heartbeatPulse 2s ease-in-out 1.3s infinite;
            }

            .animate-heartbeat {
                animation: heartbeatPulse 2s ease-in-out infinite;
            }

            .animate-bounce-gentle {
                animation: bounceGentle 1.5s ease-in-out infinite;
            }

            .animate-badge-pulse {
                animation: badgeGlow 2s ease-in-out infinite;
            }

            /* Scroll Reveal Classes */
            .reveal-item {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            }

            .reveal-item.revealed {
                opacity: 1;
                transform: translateY(0);
            }

            /* Accessibility Override */
            @media (prefers-reduced-motion: reduce) {
                html { scroll-behavior: auto; }
                .animate-line-draw {
                    stroke-dashoffset: 0;
                    animation: none !important;
                }
                .animate-heartbeat, .animate-bounce-gentle, .animate-badge-pulse {
                    animation: none !important;
                }
                .reveal-item {
                    opacity: 1 !important;
                    transform: none !important;
                    transition: opacity 0.2s ease !important;
                }
            }
        </style>
    </head>
    <body 
        x-data="{ scrolled: false, mobileOpen: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 80)"
        class="font-sans antialiased text-finpulse-gray bg-finpulse-cream min-h-screen flex flex-col justify-between selection:bg-finpulse-gold selection:text-finpulse-navy relative overflow-x-hidden"
    >

        <!-- =====================================================
             NAVIGATION BAR (Sticky, Scroll-Triggered & Responsive Mobile Menu)
             ===================================================== -->
        <header 
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="scrolled ? 'bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm py-3' : 'bg-transparent py-5'"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                
                <!-- Brand Logo & Wordmark -->
                <a href="/" wire:navigate class="inline-flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-finpulse-gold rounded-lg p-1">
                    <div class="h-10 w-10 rounded-full bg-finpulse-navy border-2 border-finpulse-gold flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="h-5 w-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="24" r="22" fill="#0B2545"/>
                            <path d="M10 24H16L19 16L24 32L28 20L31 24H38" stroke="#C89B3C" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-finpulse-navy">
                        Fin<span class="text-finpulse-gold">Pulse</span>
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#how-it-works" class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150">How It Works</a>
                    <a href="#features" class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150">Features</a>
                    <a href="#pricing" class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150">Pricing</a>
                    <a href="#faq" class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150">FAQ</a>
                </nav>

                <!-- Desktop Action Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('login') }}" wire:navigate class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150 px-3 py-2">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="px-5 py-2.5 bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-finpulse-gold">
                            Join Free
                        </a>
                    @endif
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden items-center">
                    <button 
                        @click="mobileOpen = !mobileOpen"
                        type="button"
                        aria-label="Toggle navigation menu"
                        class="p-2 rounded-lg text-finpulse-navy focus:outline-none focus:ring-2 focus:ring-finpulse-gold"
                    >
                        <div class="w-6 h-5 flex flex-col justify-between relative">
                            <span class="w-full h-0.5 bg-finpulse-navy transition-all duration-300 transform origin-left" :class="mobileOpen ? 'rotate-45 translate-x-1 -translate-y-0.5 bg-white' : ''"></span>
                            <span class="w-full h-0.5 bg-finpulse-navy transition-all duration-300" :class="mobileOpen ? 'opacity-0' : ''"></span>
                            <span class="w-full h-0.5 bg-finpulse-navy transition-all duration-300 transform origin-left" :class="mobileOpen ? '-rotate-45 translate-x-1 translate-y-0.5 bg-white' : ''"></span>
                        </div>
                    </button>
                </div>

            </div>

            <!-- Mobile Full-Screen Overlay Menu -->
            <div 
                x-show="mobileOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="fixed inset-0 z-40 bg-finpulse-navy text-white flex flex-col justify-between p-8 md:hidden"
                style="display: none;"
            >
                <div class="flex items-center justify-between">
                    <a href="/" @click="mobileOpen = false" wire:navigate class="inline-flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-finpulse-navy border-2 border-finpulse-gold flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="22" fill="#0B2545"/>
                                <path d="M10 24H16L19 16L24 32L28 20L31 24H38" stroke="#C89B3C" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-white">Fin<span class="text-finpulse-gold">Pulse</span></span>
                    </a>
                    <button @click="mobileOpen = false" aria-label="Close menu" class="text-white p-2 text-2xl font-bold">&times;</button>
                </div>

                <div class="flex flex-col gap-6 text-center text-2xl font-bold my-auto">
                    <a href="#how-it-works" @click="mobileOpen = false" class="hover:text-finpulse-gold transition-colors duration-150">How It Works</a>
                    <a href="#features" @click="mobileOpen = false" class="hover:text-finpulse-gold transition-colors duration-150">Features</a>
                    <a href="#pricing" @click="mobileOpen = false" class="hover:text-finpulse-gold transition-colors duration-150">Pricing</a>
                    <a href="#faq" @click="mobileOpen = false" class="hover:text-finpulse-gold transition-colors duration-150">FAQ</a>
                </div>

                <div class="flex flex-col gap-4 text-center">
                    <a href="{{ route('login') }}" @click="mobileOpen = false" wire:navigate class="py-3 text-lg font-semibold text-finpulse-cream hover:text-white">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" @click="mobileOpen = false" wire:navigate class="py-4 bg-finpulse-gold text-finpulse-navy font-bold text-lg rounded-xl shadow-lg">
                            Join Free
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <!-- =====================================================
             SECTION 1  HERO
             ===================================================== -->
        <section id="hero" class="relative pt-28 pb-16 lg:pt-36 lg:pb-24 lg:min-h-screen flex flex-col justify-between overflow-hidden">
            <!-- Background Pulse Pattern -->
            <div class="absolute inset-0 pointer-events-none opacity-5 flex items-center justify-center">
                <svg class="w-full max-w-6xl h-auto" viewBox="0 0 1000 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 200H300L350 50L450 350L520 120L580 200H1000" stroke="#0B2545" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 my-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Hero Content -->
                    <div class="lg:col-span-7 space-y-6 text-left">
                       

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-finpulse-navy tracking-tight leading-tight">
                            Learn the Market. <br/>
                            Track Your Money. <br/>
                            <span class="text-finpulse-gold">Invest with Confidence.</span>
                        </h1>

                        <p class="text-base sm:text-lg text-finpulse-gray leading-relaxed max-w-2xl">
                            FinPulse is where retail investors in Pakistan learn the fundamentals, follow real research, and grow  one step at a time.
                        </p>

                        <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" wire:navigate class="px-8 py-4 bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-bold text-base rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-center">
                                    Join Free
                                </a>
                            @endif
                            <a href="#how-it-works" class="px-8 py-4 bg-transparent border-2 border-finpulse-navy text-finpulse-navy hover:bg-finpulse-navy hover:text-white font-bold text-base rounded-xl transition-all duration-200 text-center">
                                See How It Works
                            </a>
                        </div>
                    </div>

                    <!-- Right Animated Pulse Logo Mark -->
                    <div class="lg:col-span-5 flex justify-center lg:justify-end">
                        <div class="relative w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96 rounded-full bg-finpulse-navy p-8 sm:p-12 shadow-2xl flex items-center justify-center border-4 border-finpulse-gold/30">
                            <svg class="w-full h-full" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="100" cy="100" r="90" fill="#0B2545"/>
                                <path class="animate-line-draw" d="M20 100H60L75 50L100 150L120 70L135 100H180" stroke="#C89B3C" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Scroll Indicator Arrow -->
            <div class="relative z-10 text-center pt-8 hidden sm:block">
                <a href="#how-it-works" aria-label="Scroll down to How It Works section" class="inline-block p-2 text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150 animate-bounce-gentle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </a>
            </div>
        </section>

        <!-- =====================================================
             SECTION 2  HOW IT WORKS
             ===================================================== -->
        <section id="how-it-works" class="py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                        Three Steps. One Goal: A Smarter Investor.
                    </h2>
                    <p class="mt-4 text-base text-finpulse-gray">
                        A structured path designed to take you from market beginner to confident investor.
                    </p>
                </div>

                <!-- 3 Steps Grid -->
                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Progress Path Line (Desktop) -->
                    <div class="hidden md:block absolute top-1/2 left-1/6 right-1/6 h-0.5 bg-gray-200 -translate-y-6 z-0">
                        <div id="step-progress-line" class="h-full bg-finpulse-gold transition-all duration-700 w-full"></div>
                    </div>

                    <!-- Step 1 -->
                    <div class="reveal-item bg-finpulse-cream/40 rounded-2xl p-8 border border-gray-100 relative z-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center text-2xl font-bold mb-6 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-finpulse-gold mb-2">Step 01</span>
                        <h3 class="text-xl font-bold text-finpulse-navy mb-3">Join the Community</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Ask questions, follow market discussions, and learn from others  completely free.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="reveal-item bg-finpulse-cream/40 rounded-2xl p-8 border border-gray-100 relative z-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center text-2xl font-bold mb-6 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-finpulse-gold mb-2">Step 02</span>
                        <h3 class="text-xl font-bold text-finpulse-navy mb-3">Learn with Structure</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Work through courses built for beginners to advanced investors, at your own pace.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="reveal-item bg-finpulse-cream/40 rounded-2xl p-8 border border-gray-100 relative z-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center text-2xl font-bold mb-6 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-finpulse-gold mb-2">Step 03</span>
                        <h3 class="text-xl font-bold text-finpulse-navy mb-3">Grow with Confidence</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Unlock premium research, live sessions, and a guided path to your first investment.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- =====================================================
             SECTION 3  FEATURE HIGHLIGHTS
             ===================================================== -->
        <section id="features" class="py-20 bg-finpulse-cream/50 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                        Everything You Need, In One Place.
                    </h2>
                    <p class="mt-4 text-base text-finpulse-gray">
                        Tools and resources tailored specifically for retail financial education.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:border-finpulse-gold md:hover:shadow-md">
                        <div class="w-12 h-12 rounded-xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-finpulse-navy mb-2">Community Feed</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Real conversations with real investors.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:border-finpulse-gold md:hover:shadow-md">
                        <div class="w-12 h-12 rounded-xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-finpulse-navy mb-2">Courses & Certificates</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Structured learning you can show off.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:border-finpulse-gold md:hover:shadow-md">
                        <div class="w-12 h-12 rounded-xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-finpulse-navy mb-2">Live Sessions</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Get your questions answered, live.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:border-finpulse-gold md:hover:shadow-md">
                        <div class="w-12 h-12 rounded-xl bg-finpulse-navy text-finpulse-gold flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-finpulse-navy mb-2">Premium Research</h3>
                        <p class="text-sm text-finpulse-gray leading-relaxed">
                            Insights the free internet won't give you.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- =====================================================
             SECTION 4  SAMPLE CONTENT PREVIEW
             ===================================================== -->
        <!-- PLACEHOLDER CONTENT: replace with real content model query once Content/Course tables exist -->
        <section class="py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                        A Taste of What You'll Learn.
                    </h2>
                    <p class="mt-4 text-base text-finpulse-gray">
                        Explore sample topics from our fundamental investment curriculum.
                    </p>
                </div>

                <div class="flex overflow-x-auto gap-6 pb-4 sm:pb-0 md:grid md:grid-cols-2 lg:grid-cols-4 snap-x snap-mandatory">
                    
                    <!-- Card 1 -->
                    <div class="snap-center shrink-0 w-72 sm:w-auto bg-finpulse-cream/30 rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:shadow-md flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-finpulse-gold text-finpulse-navy mb-4">
                                Beginner
                            </span>
                            <h3 class="text-lg font-bold text-finpulse-navy mb-2">What is a P/E Ratio?</h3>
                            <p class="text-xs text-finpulse-gray leading-relaxed">
                                Learn how price-to-earnings ratios help evaluate stock valuations.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200/60 flex items-center justify-between text-xs font-semibold text-finpulse-navy">
                            <span>Module 01</span>
                            <span>15 mins</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="snap-center shrink-0 w-72 sm:w-auto bg-finpulse-cream/30 rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:shadow-md flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-finpulse-navy text-white mb-4">
                                Intermediate
                            </span>
                            <h3 class="text-lg font-bold text-finpulse-navy mb-2">Reading a Candlestick Chart</h3>
                            <p class="text-xs text-finpulse-gray leading-relaxed">
                                Understand price action patterns, bullish engulfing lines, and trends.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200/60 flex items-center justify-between text-xs font-semibold text-finpulse-navy">
                            <span>Module 04</span>
                            <span>25 mins</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="snap-center shrink-0 w-72 sm:w-auto bg-finpulse-cream/30 rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:shadow-md flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-finpulse-navy text-white mb-4">
                                Intermediate
                            </span>
                            <h3 class="text-lg font-bold text-finpulse-navy mb-2">How the KSE-100 Works</h3>
                            <p class="text-xs text-finpulse-gray leading-relaxed">
                                A comprehensive breakdown of Pakistan stock exchange index weighting.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200/60 flex items-center justify-between text-xs font-semibold text-finpulse-navy">
                            <span>Module 07</span>
                            <span>20 mins</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="snap-center shrink-0 w-72 sm:w-auto bg-finpulse-cream/30 rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-200 md:hover:-translate-y-1 md:hover:shadow-md flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-gray-700 text-white mb-4">
                                Advanced
                            </span>
                            <h3 class="text-lg font-bold text-finpulse-navy mb-2">Building Your First Watchlist</h3>
                            <p class="text-xs text-finpulse-gray leading-relaxed">
                                Filter companies using cash flow, debt ratios, and growth metrics.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200/60 flex items-center justify-between text-xs font-semibold text-finpulse-navy">
                            <span>Module 12</span>
                            <span>30 mins</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- =====================================================
             SECTION 5  TRUST / STATS STRIP
             ===================================================== -->
        <!-- PLACEHOLDER STATS: replace with real counts once tracked -->
        <section id="stats-section" class="py-16 bg-finpulse-navy text-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-finpulse-gold mb-2" data-target="10000" data-suffix="+">
                            <span class="stat-number">10,000+</span>
                        </div>
                        <p class="text-sm font-semibold tracking-wider text-finpulse-cream/80 uppercase">Active Learners</p>
                    </div>

                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-finpulse-gold mb-2" data-target="50" data-suffix="+">
                            <span class="stat-number">50+</span>
                        </div>
                        <p class="text-sm font-semibold tracking-wider text-finpulse-cream/80 uppercase">Free & Paid Courses</p>
                    </div>

                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-finpulse-gold mb-2" data-target="200" data-suffix="+">
                            <span class="stat-number">200+</span>
                        </div>
                        <p class="text-sm font-semibold tracking-wider text-finpulse-cream/80 uppercase">Live Sessions Hosted</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- =====================================================
             SECTION 6  PRICING TEASER
             ===================================================== -->
        <section id="pricing" class="py-20 bg-finpulse-cream/40 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                        Start Free. Upgrade When You're Ready.
                    </h2>
                    <p class="mt-4 text-base text-finpulse-gray">
                        Transparent membership plans tailored for retail investors.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-stretch">
                    
                    <!-- Free Member Card -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-finpulse-navy mb-2">Free Member</h3>
                            <p class="text-sm text-finpulse-gray mb-6">Perfect for beginners taking their first steps.</p>
                            
                            <div class="text-4xl font-extrabold text-finpulse-navy mb-8">
                                Rs. 0 <span class="text-sm font-normal text-finpulse-gray">/ forever</span>
                            </div>

                            <ul class="space-y-4 text-sm text-finpulse-gray mb-8">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Access to Community Feed</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Free Introductory Courses</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Basic Market Discussions</span>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('register') }}" wire:navigate class="w-full py-3.5 px-6 rounded-xl border-2 border-finpulse-navy text-finpulse-navy hover:bg-finpulse-navy hover:text-white font-bold text-center transition-colors duration-200">
                            Join Free
                        </a>
                    </div>

                    <!-- Paid Subscriber Card (Emphasized) -->
                    <div class="bg-white rounded-3xl p-8 border-2 border-finpulse-gold shadow-xl flex flex-col justify-between relative transform md:-translate-y-2">
                        <!-- Most Popular Ribbon -->
                        <div class="absolute -top-4 right-8 bg-finpulse-gold text-finpulse-navy font-bold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full shadow-md animate-badge-pulse">
                            Most Popular
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-finpulse-navy mb-2">Paid Subscriber</h3>
                            <p class="text-sm text-finpulse-gray mb-6">For committed investors seeking deep research.</p>
                            
                            <div class="text-4xl font-extrabold text-finpulse-navy mb-8">
                                Rs. 1,500 <span class="text-sm font-normal text-finpulse-gray">/ month</span>
                            </div>

                            <ul class="space-y-4 text-sm text-finpulse-gray mb-8">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-finpulse-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>Everything in Free</strong></span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-finpulse-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Premium Research Reports</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-finpulse-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Live Q&A Webinars & Sessions</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-finpulse-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Course Certificates</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-finpulse-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Priority Community Support</span>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('register') }}" wire:navigate class="w-full py-3.5 px-6 rounded-xl bg-finpulse-navy hover:bg-finpulse-gold text-white hover:text-finpulse-navy font-bold text-center transition-colors duration-200 shadow-md">
                            Get Started Now
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <!-- =====================================================
             SECTION 7  FAQ ACCORDION
             ===================================================== -->
        <section id="faq" class="py-20 bg-white relative" x-data="{ activeFaq: null }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                        Common Questions.
                    </h2>
                    <p class="mt-4 text-base text-finpulse-gray">
                        Got questions? We've got answers.
                    </p>
                </div>

                <div class="space-y-4">
                    
                    <!-- FAQ 1 -->
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <button 
                            @click="activeFaq = (activeFaq === 1 ? null : 1)"
                            class="w-full p-6 text-left font-bold text-lg text-finpulse-navy flex items-center justify-between focus:outline-none focus:bg-finpulse-cream/30"
                        >
                            <span>Is FinPulse affiliated with a brokerage?</span>
                            <svg class="w-5 h-5 text-finpulse-gold transition-transform duration-200 shrink-0" :class="activeFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeFaq === 1" x-collapse class="px-6 pb-6 text-sm text-finpulse-gray leading-relaxed">
                            No, FinPulse is an independent financial education and research platform. We do not operate as a licensed brokerage or offer direct stock execution services.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <button 
                            @click="activeFaq = (activeFaq === 2 ? null : 2)"
                            class="w-full p-6 text-left font-bold text-lg text-finpulse-navy flex items-center justify-between focus:outline-none focus:bg-finpulse-cream/30"
                        >
                            <span>Do I need prior investing experience to start?</span>
                            <svg class="w-5 h-5 text-finpulse-gold transition-transform duration-200 shrink-0" :class="activeFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeFaq === 2" x-collapse class="px-6 pb-6 text-sm text-finpulse-gray leading-relaxed">
                            Not at all! Our beginner modules break down basic concepts, budgeting, and stock market terminology step by step.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <button 
                            @click="activeFaq = (activeFaq === 3 ? null : 3)"
                            class="w-full p-6 text-left font-bold text-lg text-finpulse-navy flex items-center justify-between focus:outline-none focus:bg-finpulse-cream/30"
                        >
                            <span>Can I cancel my subscription anytime?</span>
                            <svg class="w-5 h-5 text-finpulse-gold transition-transform duration-200 shrink-0" :class="activeFaq === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeFaq === 3" x-collapse class="px-6 pb-6 text-sm text-finpulse-gray leading-relaxed">
                            Yes, you can cancel or pause your paid subscription anytime directly from your user dashboard with no cancellation fees.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <button 
                            @click="activeFaq = (activeFaq === 4 ? null : 4)"
                            class="w-full p-6 text-left font-bold text-lg text-finpulse-navy flex items-center justify-between focus:outline-none focus:bg-finpulse-cream/30"
                        >
                            <span>Are live sessions recorded if I miss one?</span>
                            <svg class="w-5 h-5 text-finpulse-gold transition-transform duration-200 shrink-0" :class="activeFaq === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="activeFaq === 4" x-collapse class="px-6 pb-6 text-sm text-finpulse-gray leading-relaxed">
                            Yes, all live webinars and research Q&A sessions are recorded and archived for paid subscribers to watch on demand.
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- =====================================================
             SECTION 8  BOTTOM CTA BANNER
             ===================================================== -->
        <section class="py-20 bg-finpulse-navy text-white relative overflow-hidden">
            <!-- Static Pulse Pattern -->
            <div class="absolute inset-0 pointer-events-none opacity-5 flex items-center justify-center">
                <svg class="w-full max-w-6xl h-auto" viewBox="0 0 1000 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 200H300L350 50L450 350L520 120L580 200H1000" stroke="#FFFFFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Your Investing Journey Starts Today.
                </h2>
                <p class="text-lg text-finpulse-cream/80 max-w-2xl mx-auto">
                    Join thousands of retail investors mastering financial literacy and building wealth.
                </p>
                <div>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="inline-block px-10 py-4 bg-finpulse-gold hover:bg-white text-finpulse-navy font-bold text-lg rounded-xl transition-all duration-200 shadow-xl">
                            Join Free
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- =====================================================
             SECTION 9  FOOTER
             ===================================================== -->
        <footer class="bg-finpulse-navy border-t border-white/10 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    
                    <!-- Col 1: Brand -->
                    <div class="space-y-4 md:col-span-1">
                        <a href="/" wire:navigate class="inline-flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-finpulse-navy border-2 border-finpulse-gold flex items-center justify-center shrink-0">
                                <svg class="h-5 w-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="24" r="22" fill="#0B2545"/>
                                    <path d="M10 24H16L19 16L24 32L28 20L31 24H38" stroke="#C89B3C" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="font-bold text-xl text-white">Fin<span class="text-finpulse-gold">Pulse</span></span>
                        </a>
                        <p class="text-xs uppercase tracking-widest text-finpulse-gold font-bold">
                            Learn. Track. Invest.
                        </p>
                        <p class="text-xs text-finpulse-cream/70 leading-relaxed">
                            Empowering retail investors with financial literacy, research, and tools.
                        </p>
                    </div>

                    <!-- Col 2: Navigation Links -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-finpulse-gold">Company</h4>
                        <ul class="space-y-2 text-sm text-finpulse-cream/80">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Newsletter (UI Only Placeholder) -->
                    <!-- PLACEHOLDER NEWSLETTER: UI only -->
                    <div class="space-y-3 md:col-span-2">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-finpulse-gold">Stay Informed</h4>
                        <p class="text-xs text-finpulse-cream/70">Subscribe to our weekly financial insights newsletter.</p>
                        <form onsubmit="event.preventDefault();" class="flex gap-2 max-w-md">
                            <input type="email" placeholder="enter your email" class="bg-white/10 border border-white/20 rounded-lg px-4 py-2.5 text-sm text-white placeholder-finpulse-cream/50 focus:outline-none focus:border-finpulse-gold flex-1">
                            <button type="submit" class="px-5 py-2.5 bg-finpulse-gold text-finpulse-navy font-bold text-sm rounded-lg hover:bg-white transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Footer Bottom -->
                <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-finpulse-cream/60 gap-4">
                    <p>© {{ date('Y') }} FinPulse. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" aria-label="Twitter" class="hover:text-finpulse-gold transition-colors">Twitter</a>
                        <a href="#" aria-label="LinkedIn" class="hover:text-finpulse-gold transition-colors">LinkedIn</a>
                        <a href="#" aria-label="YouTube" class="hover:text-finpulse-gold transition-colors">YouTube</a>
                    </div>
                </div>

            </div>
        </footer>

        <!-- Scroll Reveal & Counter Observer Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Reduced Motion Check
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                // Intersection Observer for Reveal Elements
                const revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.reveal-item').forEach((el) => revealObserver.observe(el));

                // Stats Counter Observer
                const statsSection = document.getElementById('stats-section');
                let statsAnimated = false;

                if (statsSection) {
                    const statsObserver = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting && !statsAnimated) {
                                statsAnimated = true;
                                document.querySelectorAll('[data-target]').forEach((counter) => {
                                    const target = parseInt(counter.getAttribute('data-target'), 10);
                                    const suffix = counter.getAttribute('data-suffix') || '';
                                    const numSpan = counter.querySelector('.stat-number');

                                    if (prefersReducedMotion) {
                                        if (numSpan) numSpan.textContent = target.toLocaleString() + suffix;
                                        return;
                                    }

                                    let start = 0;
                                    const duration = 1500;
                                    const stepTime = 20;
                                    const steps = duration / stepTime;
                                    const increment = target / steps;

                                    const timer = setInterval(() => {
                                        start += increment;
                                        if (start >= target) {
                                            if (numSpan) numSpan.textContent = target.toLocaleString() + suffix;
                                            clearInterval(timer);
                                        } else {
                                            if (numSpan) numSpan.textContent = Math.floor(start).toLocaleString() + suffix;
                                        }
                                    }, stepTime);
                                });
                            }
                        });
                    }, { threshold: 0.2 });

                    statsObserver.observe(statsSection);
                }
            });
        </script>

    </body>
</html>
