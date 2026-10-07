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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#F2F6F3] text-slate-800 min-h-screen" style="font-family:'Plus Jakarta Sans',sans-serif;">
        <div class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- Left Branding Panel (Desktop) / Header (Mobile) -->
            <div class="lg:w-5/12 bg-[#061A14] text-white flex flex-col justify-between p-6 sm:p-10 lg:p-14 relative overflow-hidden shrink-0 border-r border-white/5">
                <!-- Background visual accents -->
                <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-[#39E554]/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-[#28a04a]/10 blur-3xl pointer-events-none"></div>

                <!-- Top Logo Header -->
                <div class="relative z-10">
                    <a href="/" wire:navigate class="inline-flex items-center gap-3 group">
                        <div class="h-11 w-11 rounded-xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-105 transition-transform duration-200"
                            style="background:linear-gradient(135deg,#39E554,#28a04a);box-shadow:0 4px 14px rgba(57,229,84,0.35);">
                            <span class="text-slate-950 font-black text-sm">FP</span>
                        </div>
                        <div>
                            <span class="font-extrabold text-2xl tracking-tight text-white block leading-none">Fin<span class="text-[#39E554]">Pulse</span></span>
                            <span class="text-[10px] tracking-widest uppercase text-emerald-300/80 font-bold mt-1 block">Investor Education Platform</span>
                        </div>
                    </a>
                </div>

                <!-- Middle Content / Tagline & Value Props (Desktop only) -->
                <div class="hidden lg:block relative z-10 my-auto py-10">
                    
                    <h1 class="text-3xl xl:text-4xl font-black text-white leading-tight tracking-tight mb-4">
                        Master Your Money.<br/>
                        <span class="text-[#39E554]">Build Real Wealth.</span>
                    </h1>
                    <p class="text-slate-300 text-sm xl:text-base font-normal mb-8 max-w-md leading-relaxed">
                        Structured PSX market courses, fundamental analysis frameworks, and intelligent financial tools tailored for Pakistani investors.
                    </p>

                    <div class="space-y-4 text-sm font-medium">
                        <div class="flex items-center gap-3 text-slate-200">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Learn:</strong> Expert PSX &amp; mutual funds modules</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-200">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Track:</strong> Calculators, portfolios &amp; activity streaks</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-200">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span><strong class="text-white font-semibold">Invest:</strong> Real strategies with deep conviction</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Tagline Banner -->
                <div class="relative z-10 pt-4 lg:pt-0 border-t border-white/10 lg:border-t-0 mt-4 lg:mt-0 flex items-center justify-between text-xs text-slate-400">
                    <span class="tracking-widest uppercase text-[#39E554] font-bold">Learn &middot; Track &middot; Invest</span>
                    <span class="text-white/40">&copy; {{ date('Y') }} FinPulse</span>
                </div>
            </div>

            <!-- Right Content Panel (Form Container) -->
            <div class="lg:w-7/12 flex items-center justify-center p-4 sm:p-8 lg:p-12 bg-[#F2F6F3]">
                <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_20px_50px_rgba(15,23,42,0.08)] border border-slate-200/90 p-7 sm:p-10 my-auto">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>

