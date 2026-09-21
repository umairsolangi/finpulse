<style>
    @keyframes heroFloat1 {
        0%, 100% { transform: translateY(0px) rotate(-1deg); }
        50% { transform: translateY(-12px) rotate(2deg); }
    }
    @keyframes heroFloat2 {
        0%, 100% { transform: translateY(0px) rotate(2deg); }
        50% { transform: translateY(-15px) rotate(-2deg); }
    }
    @keyframes heroFloat3 {
        0%, 100% { transform: translateY(0px) rotate(-2deg); }
        50% { transform: translateY(-10px) rotate(1deg); }
    }
    @keyframes heroFloat4 {
        0%, 100% { transform: translateY(0px) rotate(1deg); }
        50% { transform: translateY(-13px) rotate(-1deg); }
    }
    .fp-widget-float-1 { animation: heroFloat1 6s ease-in-out infinite; }
    .fp-widget-float-2 { animation: heroFloat2 8s ease-in-out infinite; }
    .fp-widget-float-3 { animation: heroFloat3 5.5s ease-in-out infinite; }
    .fp-widget-float-4 { animation: heroFloat4 7s ease-in-out infinite 1s; }

    /* Sparkline draw-in */
    @keyframes sparklineDraw {
        from { stroke-dashoffset: 200; }
        to   { stroke-dashoffset: 0; }
    }
    .fp-sparkline { stroke-dasharray: 200; animation: sparklineDraw 2.4s ease-out forwards 0.6s; }

    /* Progress bar fill */
    @keyframes progressFill  { from { width: 0% } to { width: 72% } }
    @keyframes progressFill2 { from { width: 0% } to { width: 48% } }
    .fp-progress-bar   { animation: progressFill  1.8s ease-out forwards 1s; }
    .fp-progress-bar-2 { animation: progressFill2 1.8s ease-out forwards 1.3s; }

    /* Live dot pulse */
    @keyframes fpLivePulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%       { transform: scale(1.6); opacity: 0.4; }
    }
    .fp-live-dot { animation: fpLivePulse 1.4s ease-in-out infinite; }
</style>

<!-- Main Wrapper Container with Soft Neutral Mint Light Canvas Background -->
<div class="bg-[#F2F6F3] min-h-screen flex flex-col justify-between relative overflow-hidden font-sans select-none">

    <!-- Top Floating Pill Navigation Header -->
    <header x-data="{ heroNavOpen: false }" class="max-w-6xl mx-auto w-full px-4 sm:px-6 pt-5 relative z-50">
        <div
            class="bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-full px-6 py-3 flex items-center justify-between shadow-xs">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group" aria-label="FinPulse home">
                <div
                    class="w-8 h-8 rounded-lg bg-[#39E554] flex items-center justify-center text-slate-950 font-extrabold shadow-sm group-hover:scale-105 transition-transform">
                    <span class="text-xs font-black text-slate-950">FP</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">
                    Fin<span class="text-[#28a04a]">Pulse</span>
                </span>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-700">
                <a href="#about" class="hover:text-slate-950 transition-colors">About</a>
                <a href="#how-it-works" class="hover:text-slate-950 transition-colors">How It Works</a>
                <a href="#features" class="hover:text-slate-950 transition-colors">Features</a>
                <a href="#pricing" class="hover:text-slate-950 transition-colors">Pricing</a>
                <a href="#blog" class="hover:text-slate-950 transition-colors">Blog</a>
            </nav>

            <!-- Right Header CTA Button -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="{{ route('register') }}"
                    class="bg-[#39E554] hover:bg-[#32d44b] text-slate-950 font-bold px-5 py-2 rounded-full text-sm shadow-xs hover:shadow-md transition-all">
                    Get Started
                </a>
            </div>

            <!-- Mobile Drawer Toggle -->
            <button @click="heroNavOpen = !heroNavOpen"
                class="md:hidden p-2 text-slate-700 hover:text-slate-950 focus:outline-hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!heroNavOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="heroNavOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" style="display:none;" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="heroNavOpen" x-cloak @click.away="heroNavOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden mt-2 bg-white rounded-3xl p-6 border border-slate-200 shadow-xl flex flex-col gap-4 text-center">
            <a href="#about" @click="heroNavOpen = false"
                class="text-sm font-semibold text-slate-800 hover:text-[#39E554]">About</a>
            <a href="#how-it-works" @click="heroNavOpen = false"
                class="text-sm font-semibold text-slate-800 hover:text-[#39E554]">How It Works</a>
            <a href="#features" @click="heroNavOpen = false"
                class="text-sm font-semibold text-slate-800 hover:text-[#39E554]">Features</a>
            <a href="#pricing" @click="heroNavOpen = false"
                class="text-sm font-semibold text-slate-800 hover:text-[#39E554]">Pricing</a>
            <a href="#blog" @click="heroNavOpen = false"
                class="text-sm font-semibold text-slate-800 hover:text-[#39E554]">Blog</a>
            <a href="{{ route('register') }}"
                class="bg-[#39E554] text-slate-950 font-bold py-3 rounded-full text-sm shadow-md mt-2">Join Free</a>
        </div>
    </header>

    <!-- Main Hero Center Canvas -->
    <section

        class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-12 flex-1 flex flex-col justify-center items-center text-center z-10 w-full">

        <!-- ═══ Ambient Tint Orbs — tuned for light bg ═══ -->
        <div class="absolute top-[-10%] left-[-6%] w-[380px] h-[380px] rounded-full bg-[#39E554] opacity-[0.06] blur-[100px] pointer-events-none select-none" aria-hidden="true"></div>
        <div class="absolute top-[-8%] right-[-8%] w-[320px] h-[320px] rounded-full bg-[#6366f1] opacity-[0.07] blur-[90px] pointer-events-none select-none" aria-hidden="true"></div>
        <div class="absolute bottom-[-15%] left-[30%] w-[300px] h-[300px] rounded-full bg-[#39E554] opacity-[0.05] blur-[80px] pointer-events-none select-none" aria-hidden="true"></div>

        <!-- ═══ Floating Stat Pills — light nav-pill style ═══ -->

        <!-- Pill 1 (TOP LEFT): Learners -->
        <div class="absolute top-[18%] left-[2%] sm:left-[5%] lg:left-[9%] pointer-events-none select-none z-20 fp-widget-float-1 hidden sm:flex" aria-hidden="true">
            <div class="flex items-center gap-2.5 rounded-full px-4 py-2.5 bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-md">
                <div class="w-7 h-7 rounded-full bg-[#39E554]/15 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-sm leading-none">12,400+</p>
                    <p class="text-slate-500 text-[9px] mt-0.5 font-medium">Active Learners</p>
                </div>
            </div>
        </div>

        <!-- Pill 2 (BOTTOM LEFT): PSX Live -->
        <div class="absolute bottom-[22%] left-[2%] sm:left-[4%] lg:left-[7%] pointer-events-none select-none z-20 fp-widget-float-3 hidden lg:flex" aria-hidden="true">
            <div class="flex items-center gap-2.5 rounded-full px-4 py-2.5 bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-md">
                <span class="fp-live-dot w-2 h-2 rounded-full bg-[#39E554] shrink-0 block"></span>
                <div>
                    <p class="text-slate-900 font-bold text-xs leading-none">PSX Live</p>
                    <p class="text-slate-500 text-[9px] mt-0.5">Market Open</p>
                </div>
            </div>
        </div>

        <!-- Pill 3 (TOP RIGHT): Research Insights -->
        <div class="absolute top-[18%] right-[2%] sm:right-[5%] lg:right-[9%] pointer-events-none select-none z-20 fp-widget-float-2 hidden sm:flex" aria-hidden="true">
            <div class="flex items-center gap-2.5 rounded-full px-4 py-2.5 bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-md">
                <div class="w-7 h-7 rounded-full bg-[#39E554]/15 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-sm leading-none">Weekly</p>
                    <p class="text-slate-500 text-[9px] mt-0.5 font-medium">Research Insights</p>
                </div>
            </div>
        </div>

        <!-- Pill 4 (BOTTOM RIGHT): Certificates Earned -->
        <div class="absolute bottom-[22%] right-[2%] sm:right-[4%] lg:right-[7%] pointer-events-none select-none z-20 fp-widget-float-4 hidden sm:flex" aria-hidden="true">
            <div class="flex items-center gap-2.5 rounded-full px-4 py-2.5 bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-md">
                <div class="w-7 h-7 rounded-full bg-[#39E554]/15 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-900 font-bold text-xs leading-none">50+ Courses</p>
                    <p class="text-slate-500 text-[9px] mt-0.5">Stocks, Funds & Basics</p>
                </div>
            </div>
        </div>

        <!-- Hero Central Typography & Actions Container -->
        <div class="max-w-4xl mx-auto relative z-30 px-4">

            

            <!-- Main Headline -->
            <h1
                class="text-4xl sm:text-6xl lg:text-[72px] font-black text-slate-900 tracking-tight leading-[1.08] mb-6">
                <span class="text-[#39E554] block font-extrabold">Learn. Invest. Grow.</span>
                <span class="text-slate-900 block font-black">Pakistan's Investor Education Platform</span>
            </h1>

            <!-- Subtitle Paragraph -->
            <p class="text-slate-600 text-base sm:text-lg max-w-xl mx-auto leading-relaxed mb-8 font-medium">
                From free community discussions to structured courses and live expert sessions —
                master the PSX, mutual funds, and personal finance at your own pace.
            </p>

            <!-- Main Action Button -->
            <div class="flex justify-center items-center gap-3 flex-wrap">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-[#39E554] text-slate-950 font-extrabold text-base shadow-md hover:bg-[#32d44b] hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    Join Free — No Credit Card
                </a>
                <a href="#how-it-works"
                    class="inline-flex items-center justify-center px-6 py-3.5 rounded-full border border-slate-300 text-slate-700 font-semibold text-base hover:border-slate-400 hover:text-slate-900 transition-all duration-200">
                    How It Works
                </a>
            </div>
        </div>

    </section>

    <!-- Bottom Client/Partner Logos Bar -->
    <footer class="w-full max-w-6xl mx-auto px-4 pb-10 pt-4 relative z-30">
        <div class="text-center">
            <p class="text-sm font-semibold text-slate-800 mb-8 tracking-tight">
                Trusted by fast-growing companies worldwide
            </p>

            <!-- Grid/Flex Row of Sleek Logos -->
            <div class="flex items-center justify-center flex-wrap gap-8 sm:gap-14 lg:gap-20 text-slate-500 opacity-90">

                <!-- Logo 1: Hexsmith -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.8L18.8 8 12 11.2 5.2 8 12 4.8zM4 9.6l7 3.3v6.7l-7-3.5V9.6zm16 6.5l-7 3.5v-6.7l7-3.3v6.5z" />
                    </svg>
                    <span>Hexsmith</span>
                </div>

                <!-- Logo 2: Norse Star -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5z" />
                    </svg>
                    <span>Norse Star</span>
                </div>

                <!-- Logo 3: Railspeed -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 6h16v2H4zm4 5h12v2H8zm-4 5h16v2H4z" />
                    </svg>
                    <span>Railspeed</span>
                </div>

                <!-- Logo 4: Ollio -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <circle cx="12" cy="12" r="8" />
                    </svg>
                    <span>Ollio</span>
                </div>

                <!-- Logo 5: PictelAI -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 5h2v4h-2V7zm0 6h2v4h-2v-4z" />
                    </svg>
                    <span>PictelAI</span>
                </div>

                <!-- Logo 6: Quixx -->
                <div
                    class="flex items-center gap-2 font-extrabold text-base tracking-tight text-slate-700 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2a10 10 0 106.32 17.74l1.42 1.42 1.41-1.41-1.42-1.42A10 10 0 0012 2zm0 16a6 6 0 110-12 6 6 0 010 12z" />
                    </svg>
                    <span>Quixx</span>
                </div>

            </div>
        </div>
    </footer>

</div>