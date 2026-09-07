<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FinPulse') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-finpulse-gray bg-finpulse-cream min-h-screen">
        <div class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- Left Branding Panel (Desktop) / Header (Mobile) -->
            <div class="lg:w-5/12 bg-finpulse-navy text-white flex flex-col justify-between p-6 sm:p-10 lg:p-14 relative overflow-hidden shrink-0">
                <!-- Background visual accents -->
                <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-finpulse-gold/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-finpulse-gold/10 blur-3xl pointer-events-none"></div>

                <!-- Top Logo Header -->
                <div class="relative z-10">
                    <a href="/" wire:navigate class="inline-flex items-center gap-3 group">
                        <div class="h-12 w-12 rounded-full bg-finpulse-navy border-2 border-finpulse-gold flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-200 shrink-0">
                            <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 24H16L19 16L24 32L28 20L31 24H38" stroke="#C89B3C" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-2xl tracking-tight text-white block leading-none">Fin<span class="text-finpulse-gold">Pulse</span></span>
                            <span class="text-xs tracking-wider uppercase text-finpulse-cream/70 font-medium">Financial Education</span>
                        </div>
                    </a>
                </div>

                <!-- Middle Content / Tagline & Value Props (Desktop only) -->
                <div class="hidden lg:block relative z-10 my-auto py-12">
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight tracking-tight mb-4">
                        Master Your Money. <br/>
                        <span class="text-finpulse-gold">Build Real Wealth.</span>
                    </h1>
                    <p class="text-finpulse-cream/80 text-base xl:text-lg font-normal mb-8 max-w-md leading-relaxed">
                        Empowering your financial journey with interactive lessons, intelligent portfolio tracking, and proven investment frameworks.
                    </p>

                    <div class="space-y-4 text-sm font-medium">
                        <div class="flex items-center gap-3 text-finpulse-cream/90">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-finpulse-gold/20 text-finpulse-gold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Learn:</strong> Expert-curated financial literacy modules</span>
                        </div>
                        <div class="flex items-center gap-3 text-finpulse-cream/90">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-finpulse-gold/20 text-finpulse-gold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Track:</strong> Intuitive budget & portfolio analytics</span>
                        </div>
                        <div class="flex items-center gap-3 text-finpulse-cream/90">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-finpulse-gold/20 text-finpulse-gold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Invest:</strong> Actionable strategies for long-term growth</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Tagline Banner -->
                <div class="relative z-10 pt-4 lg:pt-0 border-t border-white/10 lg:border-t-0 mt-4 lg:mt-0">
                    <p class="text-xs sm:text-sm font-semibold tracking-widest text-finpulse-gold uppercase">
                        Learn. Track. Invest.
                    </p>
                </div>
            </div>

            <!-- Right Content Panel (Form Container) -->
            <div class="lg:w-7/12 flex items-center justify-center p-4 sm:p-8 lg:p-12">
                <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-10 my-auto">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>

