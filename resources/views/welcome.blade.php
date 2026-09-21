<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth bg-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="FinPulse is Pakistan's premier financial education platform. Learn market fundamentals, track your money, and invest with confidence. Free to join.">

    <title>FinPulse — Learn. Track. Invest.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (Plugins + Core) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.8/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Observer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/MotionPathPlugin.min.js"></script>

    <!-- ApexCharts — Interactive Stock Chart Demo -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
</head>

<body x-data="{
            scrolled: false,
            mobileOpen: false,
            activeMockup: 0,
        }" @scroll.window="scrolled = (window.pageYOffset > 80)"
    class="font-sans antialiased text-[#0B132B] bg-white min-h-screen selection:bg-[#00C48C] selection:text-white relative overflow-x-hidden"
    id="page-top">
    <!-- =====================================================
             SECTION 1 — HERO COMPONENT
             ===================================================== -->
    <x-herosection />

    <!-- Scroll Progress Bar -->
    <div id="scroll-progress" class="fp-scroll-progress" style="width:0%"></div>

    <!-- Cursor Follower (desktop only) -->
    <div id="cursor-dot" class="fp-cursor-dot"></div>

    <!-- Floating Particles -->
    <div id="hero-particles" class="fixed inset-0 pointer-events-none z-[1] overflow-hidden" aria-hidden="true"></div>

    <!-- =====================================================
             SECTION 2 — ABOUT US (EXACT DESIGN AS ATTACHED)
             ===================================================== -->
    <section id="about" class="py-20 lg:py-28 relative bg-white font-['DM_Sans',sans-serif] overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <!-- Left Column: Staggered Image & Badge Collage (6 cols) -->
                <div class="lg:col-span-6 relative reveal-item">
                    <div class="relative w-full max-w-md sm:max-w-lg mx-auto">

                        <!-- Top Floating Stat Card (30,000+) -->
                        <div class="absolute -top-6 sm:-top-8 right-1 sm:right-4 z-30 bg-white/95 backdrop-blur-md rounded-2xl p-4 sm:p-5 shadow-[0_20px_45px_rgba(15,23,42,0.1)] border border-slate-100/90 w-52 sm:w-64 transform hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xl sm:text-2xl font-black text-[#0F172A] tracking-tight">30,000+</span>
                                <span class="w-6 h-6 rounded-full bg-emerald-50 text-[#00C48C] flex items-center justify-center font-bold text-sm">
                                    ↗
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed mt-1.5 mb-3">
                                Active retail learners in Pakistan with 5 star ratings and happy investors.
                            </p>
                            <!-- Overlapping Avatar Stack -->
                            <div class="flex items-center -space-x-2 overflow-hidden pt-1 border-t border-slate-100">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&auto=format&fit=crop&q=80" alt="Learner">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&auto=format&fit=crop&q=80" alt="Learner">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&auto=format&fit=crop&q=80" alt="Learner">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&auto=format&fit=crop&q=80" alt="Learner">
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full ring-2 ring-white bg-emerald-100 text-[9px] font-bold text-[#00A86B]">
                                    +8k
                                </span>
                            </div>
                        </div>

                        <!-- Staggered Two-Image Collage -->
                        <div class="grid grid-cols-2 gap-4 sm:gap-6 pt-10 sm:pt-12 items-start">
                            <!-- Left Image (Square / Elevated) -->
                            <div class="relative group pt-4">
                                <div class="rounded-3xl overflow-hidden shadow-[0_16px_36px_rgba(15,23,42,0.08)] border border-slate-100 bg-slate-50 aspect-square">
                                    <img src="{{ asset('images/about_finpulse_learn.jpg') }}"
                                         alt="FinPulse Learning Hub on Tablet"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                                </div>
                            </div>

                            <!-- Right Image (Tall / Staggered Downward) -->
                            <div class="relative group pt-12 sm:pt-14">
                                <div class="rounded-3xl overflow-hidden shadow-[0_20px_45px_rgba(15,23,42,0.12)] border border-slate-100 bg-slate-50 aspect-[3/4] sm:aspect-[3/4.2]">
                                    <img src="{{ asset('images/about_finpulse_investor.jpg') }}"
                                         alt="FinPulse Retail Investor with App"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" />
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Floating Rating Card (Best ratings) -->
                        <div class="absolute -bottom-5 sm:-bottom-7 left-1 sm:left-4 z-30 bg-white/95 backdrop-blur-md rounded-2xl px-4 py-3 shadow-[0_15px_35px_rgba(15,23,42,0.09)] border border-slate-100/90 w-44 sm:w-48 transform hover:-translate-y-1 transition-transform duration-300">
                            <div class="text-[11px] font-bold text-slate-700 tracking-wide mb-1.5">
                                Best ratings
                            </div>
                            <div class="flex items-center gap-1.5 text-base">
                                <span title="Poor">😡</span>
                                <span title="Fair">😐</span>
                                <span title="Good">🙂</span>
                                <span title="Great">😊</span>
                                <span class="relative inline-block" title="Loved it">
                                    <span class="text-lg">🤩</span>
                                    <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-[#00C48C] ring-2 ring-white"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Editorial Text Content (6 cols) -->
                <div class="lg:col-span-6 flex flex-col justify-center pl-0 lg:pl-8 reveal-item">
                    <!-- Eyebrow: "A  B  I  T" -->
                    <div class="text-xs sm:text-sm font-bold uppercase tracking-[0.3em] text-[#00A86B] mb-2">
                        A &nbsp;B &nbsp;I &nbsp;T
                    </div>

                    <!-- Big Title: "ABOUT US" -->
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#0F172A] tracking-tight uppercase leading-none mb-6">
                        ABOUT US
                    </h2>

                    <!-- Narrative Paragraphs -->
                    <div class="space-y-4 text-slate-500 text-sm sm:text-base leading-relaxed max-w-lg mb-8 font-normal">
                        <p>
                            Pakistan has over 240 million people, yet fewer than 0.2% invest in the capital markets. FinPulse was founded to dismantle those barriers — turning intimidating financial jargon, volatile PSX market swings, and opaque broker systems into structured, accessible education.
                        </p>
                        <p>
                            From mastering the fundamentals of CDC accounts, mutual funds, and KSE-100 equities to conducting fundamental balance sheet analysis and Shariah-compliant screening, we empower everyday Pakistanis to build lasting wealth with clarity and real conviction.
                        </p>
                    </div>

                    <!-- Unique Stylized Button: "EXPLORE MORE" with angular cut -->
                    <div>
                        <a href="#how-it-works"
                           class="inline-flex items-center justify-center text-white font-bold text-xs sm:text-sm uppercase tracking-wider px-8 py-4 bg-gradient-to-r from-[#00C48C] to-[#00A86B] hover:from-[#00D084] hover:to-[#00B875] shadow-[0_12px_28px_rgba(0,196,140,0.35)] hover:shadow-[0_16px_36px_rgba(0,196,140,0.5)] transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200"
                           style="border-radius: 10px; clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 100%, 0 100%);">
                            EXPLORE MORE
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =====================================================
             SECTION 3 — HOW IT WORKS (RICH FOREST GREEN & EMERALD)
             ===================================================== -->
    <section id="how-it-works" class="pt-20 pb-28 relative overflow-hidden bg-[#061A14] font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-10 reveal-item">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Three Steps. One Goal: <br class="sm:hidden" /><em
                        class="not-italic text-[#00C48C] [text-shadow:0_0_28px_rgba(0,196,140,0.35)]">A Smarter
                        Investor.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-4 text-base text-emerald-100/80 max-w-xl mx-auto">
                    A structured path designed to take you from market beginner to confident investor.
                </p>
            </div>

            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                <!-- Desktop connecting line -->
                <div class="hidden md:block absolute top-[64px] left-[calc(16.67%+20px)] right-[calc(16.67%+20px)] h-0.5 bg-[#00C48C]/20 z-0 pointer-events-none"
                    aria-hidden="true">
                    <div id="step-progress-line"
                        class="h-full bg-gradient-to-r from-[#00C48C] to-[#00A86B] transition-all duration-1000 ease-out"
                        style="width:0%"></div>
                </div>

                <!-- Step 01 -->
                <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#0B2A20]/60 border border-[#00C48C]/20 backdrop-blur-xl hover:border-[#00C48C]/60 transition-all duration-300 h-full"
                    style="--stagger:1;">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(0,196,140,0.4)] shrink-0">
                        <span class="text-white text-2xl font-black">1</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#00C48C] mb-2">Step 01</span>
                    <h3 class="text-xl font-bold text-white mb-3">Join the Community</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed flex-1">
                        Ask questions, follow market discussions, and learn from others — completely free.
                    </p>
                </div>

                <!-- Step 02 -->
                <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#0B2A20]/60 border border-[#00C48C]/20 backdrop-blur-xl hover:border-[#00C48C]/60 transition-all duration-300 h-full"
                    style="--stagger:2;">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(0,196,140,0.4)] shrink-0">
                        <span class="text-white text-2xl font-black">2</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#00C48C] mb-2">Step 02</span>
                    <h3 class="text-xl font-bold text-white mb-3">Learn with Structure</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed flex-1">
                        Work through courses built for beginners to advanced investors, at your own pace.
                    </p>
                </div>

                <!-- Step 03 -->
                <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#0B2A20]/60 border border-[#00C48C]/20 backdrop-blur-xl hover:border-[#00C48C]/60 transition-all duration-300 h-full"
                    style="--stagger:3;">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(0,196,140,0.4)] shrink-0">
                        <span class="text-white text-2xl font-black">3</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#00C48C] mb-2">Step 03</span>
                    <h3 class="text-xl font-bold text-white mb-3">Grow with Confidence</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed flex-1">
                        Unlock premium research, live sessions, and a guided path to your first investment.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
             SECTION — OUR COURSES (LIVEWIRE CAROUSEL)
             ===================================================== -->
    <livewire:course.course-carousel />

    <!-- =====================================================
             SECTION 4 — FEATURES (BENTO GRID LIGHT MODE)
             ===================================================== -->
    <section id="features" class="py-24 bg-[#F8FAFC] relative font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">

                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">
                    Everything You Need, <em class="not-italic text-[#00C48C]">In One Place.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-5 text-base text-[#475569]">
                    Tools and resources tailored specifically for retail financial education.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Large Tile: Community Feed -->
                <div class="reveal-item group relative bg-white rounded-2xl p-8 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#00C48C]/50 md:hover:shadow-xl
                                sm:col-span-2 lg:col-span-2 lg:row-span-2">
                    <div class="absolute top-6 right-6 flex gap-1.5" aria-hidden="true">
                        <div class="w-7 h-7 rounded-full bg-[#00C48C]/15 border border-[#00C48C]/30 animate-badge-pulse"
                            style="animation-delay:0s;"></div>
                        <div class="w-7 h-7 rounded-full bg-[#00A86B]/15 border border-[#00A86B]/30 animate-badge-pulse"
                            style="animation-delay:0.4s;"></div>
                        <div class="w-7 h-7 rounded-full bg-[#00C48C]/10 border border-[#00C48C]/20 animate-badge-pulse"
                            style="animation-delay:0.8s;"></div>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-6 shadow-md group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0F172A] mb-2">Community Feed</h3>
                    <p class="text-sm text-[#475569] leading-relaxed max-w-xs">Real conversations with real investors.
                    </p>
                    <div class="mt-8 space-y-3" aria-hidden="true">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-slate-200 shrink-0"></div>
                            <div class="flex-1 space-y-1">
                                <div class="h-2 bg-slate-200 rounded-full w-3/4"></div>
                                <div class="h-1.5 bg-slate-100 rounded-full w-1/2"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-slate-200 shrink-0"></div>
                            <div class="flex-1 space-y-1">
                                <div class="h-2 bg-slate-200 rounded-full w-full"></div>
                                <div class="h-1.5 bg-slate-100 rounded-full w-2/3"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-slate-200 shrink-0"></div>
                            <div class="flex-1 space-y-1">
                                <div class="h-2 bg-slate-200 rounded-full w-4/5"></div>
                                <div class="h-1.5 bg-slate-100 rounded-full w-3/5"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tile: Courses & Certificates -->
                <div
                    class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#00C48C]/50 md:hover:shadow-xl">
                    <div class="absolute top-5 right-5" aria-hidden="true">
                        <svg class="w-12 h-12 opacity-30 group-hover:opacity-60 transition-opacity duration-200"
                            viewBox="0 0 36 36" fill="none">
                            <circle cx="18" cy="18" r="15.9" stroke="#00C48C" stroke-width="3" stroke-dasharray="75 25"
                                stroke-dashoffset="25" transform="rotate(-90 18 18)" />
                        </svg>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-5 shadow-md group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] mb-2">Courses &amp; Certificates</h3>
                    <p class="text-sm text-[#475569] leading-relaxed">Structured learning you can show off.</p>
                </div>

                <!-- Tile: Live Sessions -->
                <div
                    class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#00C48C]/50 md:hover:shadow-xl">
                    <div class="absolute top-5 right-5 flex items-center gap-1.5" aria-hidden="true">
                        <span class="live-dot w-2.5 h-2.5 rounded-full bg-[#00C48C] block animate-pulse"></span>
                        <span class="text-xs font-bold text-[#00C48C] uppercase tracking-wider">Live</span>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-5 shadow-md group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] mb-2">Live Sessions</h3>
                    <p class="text-sm text-[#475569] leading-relaxed">Get your questions answered, live.</p>
                </div>

                <!-- Tile: Premium Research -->
                <div class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#00C48C]/50 md:hover:shadow-xl
                                sm:col-span-2 lg:col-span-3">
                    <div class="absolute top-5 right-6" aria-hidden="true">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-[#00C48C] transition-colors duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="flex items-start gap-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#00C48C] to-[#00A86B] flex items-center justify-center mb-0 shadow-md shrink-0 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#0F172A] mb-2">Premium Research</h3>
                            <p class="text-sm text-[#475569] leading-relaxed">Insights the free internet won't give you.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION — BROWSE COMMUNITY BY TOPIC (LIGHT MODE)
             ===================================================== -->
    <section id="community-topics"
        class="py-20 lg:py-24 relative overflow-hidden bg-white font-['DM_Sans',sans-serif] border-t border-slate-200">
        <!-- Subtle Light Background Grid -->
        <div class="absolute inset-0 pointer-events-none opacity-40 z-0" aria-hidden="true"
            style="background-image: linear-gradient(rgba(100, 116, 139, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.07) 1px, transparent 1px); background-size: 64px 64px;">
        </div>

        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="mb-14 text-center max-w-2xl mx-auto reveal-item">

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0F172A] tracking-tight">
                    Browse the Community <em class="not-italic text-[#00C48C]">by Topic.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-4 text-base sm:text-lg text-[#475569] leading-relaxed">
                    Jump straight into the discussions that matter to you.
                </p>
            </div>

            <!-- 4 Topic Cards Grid (Pure Light Mode) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Stocks Card -->
                <a href="{{ route('feed', ['category' => 'stocks']) }}" wire:navigate
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        <img alt="Stocks - Candlestick chart and market trading data"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            src="{{ asset('images/topics/stocks.jpg') }}">
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#00A86B] shadow-sm border border-slate-200/80">
                                Equities
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors">
                                Stocks
                            </h3>
                            <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                Market fundamentals, earnings reports, and KSE-100 movements.
                            </p>
                        </div>
                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                            <span>Explore Discussions</span>
                            <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                        </div>
                    </div>
                </a>

                <!-- Mutual Funds Card -->
                <a href="{{ route('feed', ['category' => 'mutual_funds']) }}" wire:navigate
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        <img alt="Mutual Funds - Wealth management and portfolio allocation"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            src="{{ asset('images/topics/mutual_funds.jpg') }}">
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#00A86B] shadow-sm border border-slate-200/80">
                                Funds &amp; Wealth
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors">
                                Mutual Funds
                            </h3>
                            <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                Portfolio growth, fund allocation, and managed investment strategies.
                            </p>
                        </div>
                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                            <span>Explore Discussions</span>
                            <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                        </div>
                    </div>
                </a>

                <!-- Basics Card -->
                <a href="{{ route('feed', ['category' => 'basics']) }}" wire:navigate
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/60 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        <img alt="Basics - Investment literacy and beginner fundamentals"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            src="{{ asset('images/topics/basics.jpg') }}">
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#00A86B] shadow-sm border border-slate-200/80">
                                Beginner
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors">
                                Basics
                            </h3>
                            <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                Budgeting rules, financial literacy, and first investment steps.
                            </p>
                        </div>
                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                            <span>Explore Discussions</span>
                            <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                        </div>
                    </div>
                </a>

                <!-- News Card -->
                <a href="{{ route('feed', ['category' => 'news']) }}" wire:navigate
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        <img alt="News - Financial market press and economic updates"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            src="{{ asset('images/topics/news.jpg') }}">
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#00A86B] shadow-sm border border-slate-200/80">
                                Market News
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors">
                                News
                            </h3>
                            <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                Daily financial headlines, economic data, and policy updates.
                            </p>
                        </div>
                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                            <span>Explore Discussions</span>
                            <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION 5 — SAMPLE CONTENT PREVIEW (RICH FOREST GREEN & EMERALD)
             ===================================================== -->
    <section class="py-24 relative overflow-hidden bg-[#061A14] font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    A Taste of <em class="not-italic text-[#00C48C] [text-shadow:0_0_28px_rgba(0,196,140,0.35)]">What
                        You'll Learn.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-5 text-base text-emerald-100/80">
                    Explore sample topics from our fundamental investment curriculum.
                </p>
            </div>

            <div
                class="flex overflow-x-auto gap-5 pb-4 sm:pb-0 md:grid md:grid-cols-2 lg:grid-cols-4 snap-x snap-mandatory -mx-4 px-4 sm:mx-0 sm:px-0">
                <div
                    class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#0B2A20]/60 rounded-2xl p-6 border border-[#00C48C]/20 backdrop-blur-xl shadow-lg hover:border-[#00C48C]/60 hover:shadow-[0_0_30px_rgba(0,196,140,0.25)] transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#00C48C]/20 text-[#00C48C] border border-[#00C48C]/30 mb-4">Beginner</span>
                        <h3 class="text-lg font-bold text-white mb-2">What is a P/E Ratio?</h3>
                        <p class="text-xs text-emerald-100/70 leading-relaxed">Learn how price-to-earnings ratios help
                            evaluate stock valuations.</p>
                    </div>
                    <div
                        class="mt-6 pt-4 border-t border-[#00C48C]/20 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                        <span>Module 01</span>
                        <span class="text-emerald-100/60 font-medium">15 mins</span>
                    </div>
                </div>

                <div
                    class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#0B2A20]/60 rounded-2xl p-6 border border-[#00C48C]/20 backdrop-blur-xl shadow-lg hover:border-[#00C48C]/60 hover:shadow-[0_0_30px_rgba(0,196,140,0.25)] transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#00A86B]/20 text-[#00C48C] border border-[#00C48C]/30 mb-4">Intermediate</span>
                        <h3 class="text-lg font-bold text-white mb-2">Reading a Candlestick Chart</h3>
                        <p class="text-xs text-emerald-100/70 leading-relaxed">Understand price action patterns, bullish
                            engulfing lines, and trends.</p>
                    </div>
                    <div
                        class="mt-6 pt-4 border-t border-[#00C48C]/20 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                        <span>Module 04</span>
                        <span class="text-emerald-100/60 font-medium">25 mins</span>
                    </div>
                </div>

                <div
                    class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#0B2A20]/60 rounded-2xl p-6 border border-[#00C48C]/20 backdrop-blur-xl shadow-lg hover:border-[#00C48C]/60 hover:shadow-[0_0_30px_rgba(0,196,140,0.25)] transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#00A86B]/20 text-[#00C48C] border border-[#00C48C]/30 mb-4">Intermediate</span>
                        <h3 class="text-lg font-bold text-white mb-2">How the KSE-100 Works</h3>
                        <p class="text-xs text-emerald-100/70 leading-relaxed">A comprehensive breakdown of Pakistan
                            stock exchange index weighting.</p>
                    </div>
                    <div
                        class="mt-6 pt-4 border-t border-[#00C48C]/20 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                        <span>Module 07</span>
                        <span class="text-emerald-100/60 font-medium">20 mins</span>
                    </div>
                </div>

                <div
                    class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#0B2A20]/60 rounded-2xl p-6 border border-[#00C48C]/20 backdrop-blur-xl shadow-lg hover:border-[#00C48C]/60 hover:shadow-[0_0_30px_rgba(0,196,140,0.25)] transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#00C48C]/30 text-[#00C48C] border border-[#00C48C]/30 mb-4">Advanced</span>
                        <h3 class="text-lg font-bold text-white mb-2">Building Your First Watchlist</h3>
                        <p class="text-xs text-emerald-100/70 leading-relaxed">Filter companies using cash flow, debt
                            ratios, and growth metrics.</p>
                    </div>
                    <div
                        class="mt-6 pt-4 border-t border-[#00C48C]/20 flex items-center justify-between text-xs font-semibold text-[#00C48C]">
                        <span>Module 12</span>
                        <span class="text-emerald-100/60 font-medium">30 mins</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION 6 — STATS STRIP (LIGHT MODE HIGH-CONTRAST)
             ===================================================== -->
    <section id="stats-section" class="py-20 relative overflow-hidden bg-white border-y border-slate-200/90 shadow-sm">
        <div class="absolute inset-0 pointer-events-none opacity-10" aria-hidden="true"
            style="background-image: radial-gradient(circle at 50% 50%, rgba(0,196,140,0.2), transparent 70%);"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <div class="min-h-[100px] flex flex-col justify-center">
                    <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums"
                        data-target="10000" data-suffix="+">
                        <span class="stat-number">0</span>
                    </div>
                    <div class="w-12 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mb-3 stat-underline"
                        aria-hidden="true"></div>
                    <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Active Learners</p>
                </div>
                <div class="min-h-[100px] flex flex-col justify-center">
                    <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums" data-target="50"
                        data-suffix="+">
                        <span class="stat-number">0</span>
                    </div>
                    <div class="w-12 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mb-3 stat-underline"
                        aria-hidden="true"></div>
                    <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Courses</p>
                </div>
                <div class="min-h-[100px] flex flex-col justify-center">
                    <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums" data-target="180"
                        data-suffix="+">
                        <span class="stat-number">0</span>
                    </div>
                    <div class="w-12 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mb-3 stat-underline"
                        aria-hidden="true"></div>
                    <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Live Sessions</p>
                </div>
            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION — PSX STOCK SEARCH + INTERACTIVE CHART
             ===================================================== -->
    <div x-data="stockDashboard()" x-init="initChart()">

        <!-- ── Stock Search ── -->
        <section id="stock-search" class="py-20 bg-white border-t border-slate-200 font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-3xl mx-auto mb-12 reveal-item">
                    <span
                        class="inline-block px-4 py-1.5 rounded-full bg-[#00C48C]/10 text-[#00A86B] text-xs font-bold uppercase tracking-wider mb-4">PSX
                        Market</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">
                        Explore <em class="not-italic text-[#00C48C]">PSX Stocks.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                    <p class="mt-4 text-base text-[#475569]">Search Pakistan's top listed companies and view their
                        interactive chart below.</p>
                </div>

                <!-- Search Input -->
                <div class="max-w-2xl mx-auto relative mb-5 reveal-item" @click.away="searchOpen = false">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" x-model="query" @input="filterResults()" @focus="searchOpen = true"
                            placeholder="Search ticker or company... e.g. MCB, OGDC, HBL"
                            class="w-full pl-12 pr-10 py-4 rounded-2xl border border-slate-200 bg-white shadow-md text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#00C48C]/40 focus:border-[#00C48C] transition-all" />
                        <button x-show="query.length > 0" @click="query = ''; filterResults()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Dropdown -->
                    <div x-show="searchOpen && filteredStocks.length > 0" x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full left-0 right-0 mt-2 bg-white border border-slate-200 rounded-2xl shadow-2xl z-50 overflow-hidden">
                        <template x-for="s in filteredStocks.slice(0, 6)" :key="s.ticker">
                            <button @click="selectStock(s)"
                                class="w-full px-5 py-3.5 flex items-center justify-between hover:bg-slate-50 border-b border-slate-100 last:border-0 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-[#00C48C]/10 flex items-center justify-center shrink-0">
                                        <span class="text-[9px] font-black text-[#00A86B]" x-text="s.ticker"></span>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-bold text-slate-900" x-text="s.name"></p>
                                        <p class="text-[10px] text-slate-400" x-text="s.sector"></p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0 ml-3">
                                    <p class="text-sm font-bold text-slate-800"
                                        x-text="'PKR ' + s.price.toLocaleString()"></p>
                                    <p class="text-xs font-bold"
                                        :class="s.change >= 0 ? 'text-[#00C48C]' : 'text-red-500'"
                                        x-text="(s.change >= 0 ? '+' : '') + s.change + '%'"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Quick picks -->
                <div class="flex flex-wrap gap-2 justify-center mb-8">
                    <span class="text-xs text-slate-400 font-medium self-center">Trending:</span>
                    <template x-for="t in ['MCB', 'OGDC', 'ENGRO', 'TRG', 'LUCK', 'HBL']" :key="t">
                        <button @click="selectByTicker(t)"
                            class="px-3 py-1.5 rounded-full text-xs font-bold border transition-all duration-200"
                            :class="selected && selected.ticker === t ? 'bg-[#00C48C] text-white border-[#00C48C]' : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-[#00C48C]/60 hover:text-[#00A86B]'"
                            x-text="t"></button>
                    </template>
                </div>

                <!-- Market snapshot cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto reveal-item">
                    <template x-for="s in stocks.slice(0, 4)" :key="s.ticker + '_snap'">
                        <button @click="selectStock(s)"
                            class="rounded-2xl border p-4 text-left transition-all duration-200"
                            :class="selected && selected.ticker === s.ticker ? 'border-[#00C48C]/60 bg-[#00C48C]/5 shadow-md' : 'border-slate-200 bg-white hover:border-[#00C48C]/40 hover:shadow-sm'">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest"
                                    x-text="s.ticker"></span>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full"
                                    :class="s.change >= 0 ? 'text-[#00C48C] bg-[#00C48C]/10' : 'text-red-500 bg-red-50'"
                                    x-text="(s.change >= 0 ? '+' : '') + s.change + '%'"></span>
                            </div>
                            <p class="text-sm font-extrabold text-slate-900" x-text="'PKR ' + s.price.toLocaleString()">
                            </p>
                            <p class="text-[9px] text-slate-400 mt-0.5 truncate" x-text="s.name"></p>
                        </button>
                    </template>
                </div>
            </div>
        </section>

        <!-- ── Interactive Chart ── -->
        <section id="stock-chart" class="py-20 bg-[#061A14] font-['DM_Sans',sans-serif] relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-[#00C48C]/5 rounded-full blur-[100px] pointer-events-none"
                aria-hidden="true"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 mb-8 reveal-item">
                    <div>
                        <div class="flex items-center gap-3 flex-wrap mb-1">
                            <span class="text-lg sm:text-2xl font-black text-white"
                                x-text="selected ? selected.name : ''"></span>
                            <span class="px-2 py-0.5 rounded-full bg-[#00C48C]/20 text-[#00C48C] text-xs font-bold"
                                x-text="selected ? selected.ticker : ''"></span>
                            <span class="px-2 py-0.5 rounded-full bg-white/5 text-slate-400 text-xs"
                                x-text="selected ? selected.sector : ''"></span>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-3xl font-black text-white"
                                x-text="selected ? 'PKR ' + selected.price.toLocaleString() : ''"></span>
                            <span class="text-sm font-bold px-2.5 py-1 rounded-full"
                                :class="selected && selected.change >= 0 ? 'text-[#00C48C] bg-[#00C48C]/15' : 'text-red-400 bg-red-500/15'"
                                x-text="selected ? (selected.change >= 0 ? '▲ +' : '▼ ') + selected.change + '%' : ''"></span>
                        </div>
                    </div>
                    <!-- Time tabs -->
                    <div class="flex items-center gap-1 bg-white/5 border border-white/10 rounded-xl p-1 self-start">
                        <template x-for="p in ['1W','1M','3M','1Y']" :key="p">
                            <button @click="setTimePeriod(p)"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                                :class="timePeriod === p ? 'bg-[#00C48C] text-white shadow-sm' : 'text-slate-400 hover:text-white'"
                                x-text="p"></button>
                        </template>
                    </div>
                </div>

                <!-- Key metrics -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6 reveal-item">
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Volume</p>
                        <p class="text-sm font-bold text-white" x-text="selected ? selected.volume : '-'"></p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">Market Cap</p>
                        <p class="text-sm font-bold text-white" x-text="selected ? selected.marketCap : '-'"></p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">P/E Ratio</p>
                        <p class="text-sm font-bold text-white" x-text="selected ? selected.pe : '-'"></p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1">52W High</p>
                        <p class="text-sm font-bold text-white"
                            x-text="selected ? 'PKR ' + selected.high52w.toLocaleString() : '-'"></p>
                    </div>
                </div>

                <!-- Chart container -->
                <div
                    class="bg-[#0B2A20]/40 border border-[#00C48C]/15 rounded-2xl p-4 sm:p-6 backdrop-blur-sm reveal-item">
                    <div x-ref="chartEl" style="min-height:280px;"></div>
                </div>
                <p class="text-center text-xs text-slate-600 mt-4">* Simulated price data for educational purposes only.
                    Not financial advice.</p>
            </div>
        </section>
    </div>

    <script>
        function stockDashboard() {
            var stocks = [
                { ticker: 'MCB', name: 'MCB Bank Ltd.', sector: 'Banking', price: 204.50, change: 2.3, volume: '3.2M', marketCap: 'PKR 243B', pe: '7.2x', high52w: 218 },
                { ticker: 'OGDC', name: 'Oil & Gas Dev. Co.', sector: 'Oil & Gas', price: 178.25, change: 1.1, volume: '5.8M', marketCap: 'PKR 765B', pe: '5.8x', high52w: 195 },
                { ticker: 'HBL', name: 'Habib Bank Ltd.', sector: 'Banking', price: 156.80, change: -0.8, volume: '2.1M', marketCap: 'PKR 212B', pe: '6.5x', high52w: 172.5 },
                { ticker: 'ENGRO', name: 'Engro Corporation', sector: 'Fertilizer', price: 289.75, change: 0.5, volume: '1.4M', marketCap: 'PKR 156B', pe: '9.1x', high52w: 310 },
                { ticker: 'PSO', name: 'Pakistan State Oil', sector: 'Oil & Gas', price: 334.50, change: 3.2, volume: '4.2M', marketCap: 'PKR 185B', pe: '4.3x', high52w: 368 },
                { ticker: 'LUCK', name: 'Lucky Cement Ltd.', sector: 'Cement', price: 882.00, change: 1.8, volume: '0.9M', marketCap: 'PKR 273B', pe: '11.2x', high52w: 940 },
                { ticker: 'UBL', name: 'United Bank Ltd.', sector: 'Banking', price: 198.60, change: 0.3, volume: '1.8M', marketCap: 'PKR 205B', pe: '6.8x', high52w: 215 },
                { ticker: 'TRG', name: 'TRG Pakistan Ltd.', sector: 'Technology', price: 130.20, change: 4.1, volume: '6.3M', marketCap: 'PKR 52B', pe: '22.4x', high52w: 148 },
                { ticker: 'MEBL', name: 'Meezan Bank Ltd.', sector: 'Banking', price: 186.90, change: 1.5, volume: '3.5M', marketCap: 'PKR 271B', pe: '8.3x', high52w: 204 },
                { ticker: 'NESTLE', name: 'Nestlé Pakistan Ltd.', sector: 'FMCG', price: 6250, change: -1.2, volume: '0.1M', marketCap: 'PKR 294B', pe: '28.6x', high52w: 7100 },
                { ticker: 'FFBL', name: 'Fauji Fertilizer BQ', sector: 'Fertilizer', price: 28.40, change: -0.4, volume: '8.2M', marketCap: 'PKR 32B', pe: '6.1x', high52w: 38 },
                { ticker: 'PKGS', name: 'Packages Ltd.', sector: 'Packaging', price: 523, change: -0.9, volume: '0.3M', marketCap: 'PKR 62B', pe: '14.3x', high52w: 590 },
            ];
            var cache = {};
            function genData(base, days) {
                var data = [], price = base * (0.88 + Math.random() * 0.07), now = Date.now();
                var step = days <= 90 ? 86400000 : 604800000;
                var n = days <= 90 ? days : 52;
                for (var i = n; i >= 0; i--) {
                    price = Math.max(base * 0.45, price * (1 + (Math.random() - 0.47) * 0.02));
                    data.push({ x: now - i * step, y: parseFloat(price.toFixed(2)) });
                }
                data[data.length - 1].y = base;
                return data;
            }
            stocks.forEach(function (s) {
                cache[s.ticker] = { '1W': genData(s.price, 7), '1M': genData(s.price, 30), '3M': genData(s.price, 90), '1Y': genData(s.price, 365) };
            });
            return {
                stocks: stocks, filteredStocks: stocks, selected: stocks[0],
                query: '', searchOpen: false, timePeriod: '1M', chart: null,
                filterResults: function () {
                    var q = this.query.toLowerCase();
                    this.filteredStocks = q ? this.stocks.filter(function (s) { return s.ticker.toLowerCase().includes(q) || s.name.toLowerCase().includes(q) || s.sector.toLowerCase().includes(q); }) : this.stocks;
                    this.searchOpen = true;
                },
                selectStock: function (stock) { this.selected = stock; this.query = ''; this.searchOpen = false; this.updateChart(); },
                selectByTicker: function (t) { var s = this.stocks.find(function (x) { return x.ticker === t; }); if (s) this.selectStock(s); },
                setTimePeriod: function (p) { this.timePeriod = p; this.updateChart(); },
                initChart: function () {
                    var self = this;
                    this.$nextTick(function () {
                        var el = self.$refs.chartEl;
                        if (!el || typeof ApexCharts === 'undefined') return;
                        self.chart = new ApexCharts(el, self.buildOptions());
                        self.chart.render();
                    });
                },
                updateChart: function () { if (this.chart) this.chart.updateOptions(this.buildOptions(), true, true); },
                buildOptions: function () {
                    var s = this.selected, p = this.timePeriod;
                    var color = s && s.change >= 0 ? '#00C48C' : '#ef4444';
                    var data = cache[s.ticker][p];
                    return {
                        series: [{ name: s.ticker, data: data }],
                        chart: { type: 'area', height: 280, background: 'transparent', toolbar: { show: false }, animations: { enabled: true, speed: 500 }, zoom: { enabled: false } },
                        colors: [color],
                        fill: { type: 'gradient', gradient: { colorStops: [{ offset: 0, color: color, opacity: 0.2 }, { offset: 100, color: color, opacity: 0 }] } },
                        stroke: { curve: 'smooth', width: 2.5 },
                        xaxis: { type: 'datetime', labels: { style: { colors: '#64748b', fontSize: '11px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
                        yaxis: { opposite: true, labels: { style: { colors: '#64748b', fontSize: '11px' }, formatter: function (v) { return 'PKR ' + Math.round(v); } } },
                        grid: { borderColor: 'rgba(255,255,255,0.05)', strokeDashArray: 4, xaxis: { lines: { show: false } } },
                        tooltip: { theme: 'dark', x: { format: 'dd MMM yy' }, y: { formatter: function (v) { return 'PKR ' + v.toFixed(2); } } },
                        dataLabels: { enabled: false }, markers: { size: 0 },
                    };
                },
            };
        }
    </script>

    <!-- =====================================================
             SECTION — INVESTMENT / SIP CALCULATOR
             ===================================================== -->
    <section id="calculator" class="py-24 bg-white border-t border-slate-200 font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal-item">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-[#00C48C]/10 text-[#00A86B] text-xs font-bold uppercase tracking-wider mb-4">SIP
                    Calculator</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">
                    Plan Your <em class="not-italic text-[#00C48C]">Wealth Journey.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-4 text-base text-[#475569]">See how your regular investments compound into serious wealth
                    over time.</p>
            </div>

            <div x-data="{
                    initial: 50000,
                    monthly: 10000,
                    rate: 15,
                    years: 5,
                    get totalInvested() { return this.initial + (this.monthly * this.years * 12); },
                    get finalValue() {
                        var r = this.rate / 100 / 12, n = this.years * 12;
                        var lump = this.initial * Math.pow(1 + r, n);
                        var sip  = r > 0 ? this.monthly * ((Math.pow(1 + r, n) - 1) / r) * (1 + r) : this.monthly * n;
                        return Math.round(lump + sip);
                    },
                    get returns() { return Math.max(0, this.finalValue - this.totalInvested); },
                    get returnsPct() { return Math.min(100, Math.round((this.returns / Math.max(1, this.finalValue)) * 100)); },
                    fmt: function(n) { return 'PKR ' + Math.round(n).toLocaleString(); }
                }" class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto reveal-item">

                <!-- Inputs -->
                <div class="bg-[#F8FAFC] border border-slate-200 rounded-3xl p-8 space-y-7">
                    <div>
                        <div class="flex justify-between mb-2.5">
                            <label class="text-sm font-bold text-slate-700">Initial Investment</label>
                            <span class="text-sm font-extrabold text-[#00A86B]" x-text="fmt(initial)"></span>
                        </div>
                        <input type="range" x-model.number="initial" min="0" max="1000000" step="5000"
                            class="w-full h-2 rounded-full appearance-none cursor-pointer accent-[#00C48C] bg-slate-200" />
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1.5"><span>PKR 0</span><span>PKR
                                10L</span></div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2.5">
                            <label class="text-sm font-bold text-slate-700">Monthly SIP Amount</label>
                            <span class="text-sm font-extrabold text-[#00A86B]" x-text="fmt(monthly)"></span>
                        </div>
                        <input type="range" x-model.number="monthly" min="1000" max="200000" step="1000"
                            class="w-full h-2 rounded-full appearance-none cursor-pointer accent-[#00C48C] bg-slate-200" />
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1.5"><span>PKR 1K</span><span>PKR
                                2L</span></div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2.5">
                            <label class="text-sm font-bold text-slate-700">Expected Annual Return</label>
                            <span class="text-sm font-extrabold text-[#00A86B]" x-text="rate + '% p.a.'"></span>
                        </div>
                        <input type="range" x-model.number="rate" min="5" max="30" step="0.5"
                            class="w-full h-2 rounded-full appearance-none cursor-pointer accent-[#00C48C] bg-slate-200" />
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1.5">
                            <span>5%</span><span>30%</span></div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2.5">
                            <label class="text-sm font-bold text-slate-700">Investment Period</label>
                            <span class="text-sm font-extrabold text-[#00A86B]"
                                x-text="years + (years == 1 ? ' Year' : ' Years')"></span>
                        </div>
                        <input type="range" x-model.number="years" min="1" max="30" step="1"
                            class="w-full h-2 rounded-full appearance-none cursor-pointer accent-[#00C48C] bg-slate-200" />
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1.5"><span>1 Year</span><span>30
                                Years</span></div>
                    </div>
                </div>

                <!-- Results -->
                <div class="flex flex-col gap-5">
                    <div
                        class="bg-gradient-to-br from-[#00D084] to-[#00A86B] rounded-3xl p-8 text-center shadow-2xl shadow-[#00C48C]/20 relative overflow-hidden flex-1 flex flex-col justify-center">
                        <div class="absolute -top-8 -right-8 w-44 h-44 bg-white/10 rounded-full blur-2xl"
                            aria-hidden="true"></div>
                        <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider mb-3">Estimated Final
                            Corpus</p>
                        <p class="text-4xl sm:text-5xl font-black text-white leading-none" x-text="fmt(finalValue)"></p>
                        <p class="text-sm text-emerald-100/80 mt-3"
                            x-text="'After ' + years + ' yrs at ' + rate + '% p.a.'"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-[#F8FAFC] border border-slate-200 rounded-2xl p-5 text-center">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Total Invested
                            </p>
                            <p class="text-base font-extrabold text-slate-900" x-text="fmt(totalInvested)"></p>
                        </div>
                        <div class="bg-[#F8FAFC] border border-slate-200 rounded-2xl p-5 text-center">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Est. Returns
                            </p>
                            <p class="text-base font-extrabold text-[#00A86B]" x-text="fmt(returns)"></p>
                        </div>
                    </div>
                    <div class="bg-[#F8FAFC] border border-slate-200 rounded-2xl p-5">
                        <div class="flex justify-between text-xs font-bold text-slate-500 mb-2">
                            <span class="flex items-center gap-1.5"><span
                                    class="w-2.5 h-2.5 rounded-sm bg-slate-300 inline-block"></span>Invested</span>
                            <span class="flex items-center gap-1.5"><span
                                    class="w-2.5 h-2.5 rounded-sm bg-[#00C48C] inline-block"></span>Returns</span>
                        </div>
                        <div class="flex h-4 rounded-full overflow-hidden bg-slate-200">
                            <div class="bg-slate-400 h-full transition-all duration-500"
                                :style="'width:' + (100 - returnsPct) + '%'"></div>
                            <div class="bg-gradient-to-r from-[#00C48C] to-[#00A86B] h-full transition-all duration-500"
                                :style="'width:' + returnsPct + '%'"></div>
                        </div>
                        <p class="text-[10px] text-center text-slate-400 mt-2">Your corpus is <span
                                class="font-bold text-[#00A86B]"
                                x-text="(finalValue > 0 ? Math.round((finalValue / Math.max(1, totalInvested) - 1) * 100) : 0) + '% larger'"></span>
                            than total invested.</p>
                    </div>
                    <p class="text-[10px] text-slate-400 text-center">* Projections only. Returns not guaranteed.
                        Consult a financial advisor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
             SECTION — BLOG / ARTICLE CARDS
             ===================================================== -->
    <section id="blog" class="py-24 bg-[#F8FAFC] border-t border-slate-200 font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 reveal-item">
                <div>
                    <span
                        class="inline-block px-4 py-1.5 rounded-full bg-[#00C48C]/10 text-[#00A86B] text-xs font-bold uppercase tracking-wider mb-3">FinPulse
                        Blog</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">Latest <em
                            class="not-italic text-[#00C48C]">Insights.</em></h2>
                </div>
                <a href="#"
                    class="text-sm font-bold text-[#00A86B] hover:text-[#007a52] flex items-center gap-1.5 transition-colors group shrink-0">
                    View All Articles <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Article 1 -->
                <a href="#"
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div
                        class="relative aspect-[16/10] bg-gradient-to-br from-[#00A86B] to-[#007a52] flex items-center justify-center overflow-hidden">
                        <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2" />
                        </svg>
                        <div class="absolute bottom-3 left-3"><span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/95 text-[#00A86B]">PSX
                                Basics</span></div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3
                                class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors leading-snug mb-2">
                                How to Read the KSE-100 Index: A Beginner's Complete Guide</h3>
                            <p class="text-xs text-[#64748B] leading-relaxed">Understand what the KSE-100 measures, why
                                it moves, and how to use it to make smarter investment decisions.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#00C48C]/15 flex items-center justify-center"><span
                                        class="text-[8px] font-black text-[#00A86B]">FP</span></div>
                                <span class="text-xs font-medium text-slate-600">FinPulse Team</span>
                            </div>
                            <span class="text-[10px] text-slate-400">8 min · Sep 2026</span>
                        </div>
                    </div>
                </a>

                <!-- Article 2 -->
                <a href="#"
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div
                        class="relative aspect-[16/10] bg-gradient-to-br from-[#4e5bff] to-[#3730d1] flex items-center justify-center overflow-hidden">
                        <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="absolute bottom-3 left-3"><span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/95 text-[#4e5bff]">Mutual
                                Funds</span></div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3
                                class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors leading-snug mb-2">
                                Mutual Funds vs Direct Stocks: Which Strategy Fits You?</h3>
                            <p class="text-xs text-[#64748B] leading-relaxed">Compare the risks, returns, and
                                suitability of both to decide which investment approach matches your goals.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#4e5bff]/15 flex items-center justify-center"><span
                                        class="text-[8px] font-black text-[#4e5bff]">AK</span></div>
                                <span class="text-xs font-medium text-slate-600">Ahmed Khan</span>
                            </div>
                            <span class="text-[10px] text-slate-400">12 min · Aug 2026</span>
                        </div>
                    </div>
                </a>

                <!-- Article 3 -->
                <a href="#"
                    class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#00C48C]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div
                        class="relative aspect-[16/10] bg-gradient-to-br from-[#f59e0b] to-[#d97706] flex items-center justify-center overflow-hidden">
                        <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="absolute bottom-3 left-3"><span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/95 text-[#d97706]">Fundamentals</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3
                                class="text-base font-bold text-[#0F172A] group-hover:text-[#00C48C] transition-colors leading-snug mb-2">
                                How to Read a Company's Financial Statements</h3>
                            <p class="text-xs text-[#64748B] leading-relaxed">Decode income statements, balance sheets,
                                and cash flow reports to make confident, data-driven decisions.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center"><span
                                        class="text-[8px] font-black text-amber-600">SR</span></div>
                                <span class="text-xs font-medium text-slate-600">Sara Raza</span>
                            </div>
                            <span class="text-[10px] text-slate-400">10 min · Jul 2026</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- =====================================================
             SECTION 7 — PRICING (RICH FOREST GREEN & EMERALD)
             ===================================================== -->
    <section id="pricing" class="py-24 bg-[#061A14] relative font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">

                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Start Free. <em
                        class="not-italic text-[#00C48C] [text-shadow:0_0_28px_rgba(0,196,140,0.35)]">Upgrade When
                        You're Ready.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
                <p class="mt-5 text-base text-emerald-100/80">
                    Transparent membership plans tailored for retail investors.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-center">
                <!-- Free Member Card -->
                <div
                    class="reveal-item bg-[#0B2A20]/50 rounded-3xl p-8 border border-[#00C48C]/20 backdrop-blur-xl shadow-xl hover:border-[#00C48C]/50 transition-all duration-300 flex flex-col h-full">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-2">Free Member</h3>
                        <p class="text-sm text-emerald-100/70 mb-6">Perfect for beginners taking their first steps.</p>
                        <div class="text-4xl font-extrabold text-white mb-8">
                            Rs. 0 <span class="text-sm font-normal text-emerald-100/60">/ forever</span>
                        </div>
                        <ul class="space-y-4 text-sm text-emerald-100/80 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Full Community Feed Access</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Free Explainer Videos & Glossaries</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Post, Comment & Earn Badges</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>PSX Stock Explorer & SIP Calculator</span>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" wire:navigate
                        class="w-full py-3.5 px-6 rounded-xl border border-[#00C48C]/40 text-white hover:bg-[#00C48C] hover:border-[#00C48C] font-bold text-center transition-all duration-200 block">
                        Join Free
                    </a>
                </div>

                <!-- Paid Subscriber Card -->
                <div
                    class="reveal-item bg-[#0B2A20]/80 rounded-3xl p-8 border-2 border-[#00C48C] shadow-[0_0_50px_rgba(0,196,140,0.3)] backdrop-blur-xl flex flex-col relative h-full md:-translate-y-3">
                    <div
                        class="absolute -top-4 right-8 bg-gradient-to-r from-[#00C48C] to-[#00A86B] text-white font-bold text-xs uppercase tracking-widest px-5 py-1.5 rounded-full shadow-lg">
                        Most Popular
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-2">Paid Subscriber</h3>
                        <p class="text-sm text-emerald-100/70 mb-6">For committed investors seeking deep research & live
                            access.</p>
                        <div class="text-4xl font-extrabold text-white mb-1">
                            Rs. 1,500 <span class="text-sm font-normal text-emerald-100/60">/ month</span>
                        </div>
                        <p class="text-xs text-emerald-100/50 mb-8">PKR 1,000–2,500 range · cancel anytime</p>
                        <ul class="space-y-4 text-sm text-emerald-100/80 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white"><strong>Everything in Free</strong></span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">In-Depth Research Reports</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">Model Portfolios</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">Advanced Valuation Courses</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">Live Webinars & 1-on-1 Sessions</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">Shareable Course Certificates</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-[#00C48C]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-white">In-App Brokerage Account Path</span>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" wire:navigate
                        class="fin-btn-primary w-full !py-4 text-center block !text-base">
                        Get Started Now
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION 8 — FAQ ACCORDION (SIMPLE & FUNCTIONAL)
             ===================================================== -->
    @php
        $faqs = [
            ['id' => 1, 'q' => 'Do I need to open a trading or brokerage account to use FinPulse?', 'a' => 'No. FinPulse is a learning platform, not a broker. You don\'t need any trading account to join the community, take courses, or read research — everything works on its own.'],
            ['id' => 2, 'q' => 'Can I switch between the Free and Paid plans?', 'a' => 'Yes. You can upgrade to the paid plan whenever you\'re ready, and you can also cancel and go back to the free plan at any time.'],
            ['id' => 3, 'q' => 'Are there any other charges besides the subscription fee?', 'a' => 'No hidden fees. The subscription price you see is what you pay — no extra charges for accessing courses, research, or the community.'],
            ['id' => 4, 'q' => 'What payment methods do you accept?', 'a' => 'We accept credit cards, debit cards, bank transfers, and local mobile wallets through Safepay.'],
            ['id' => 5, 'q' => 'How does the community feed work?', 'a' => 'It\'s an active space where verified members discuss PSX stocks, share analysis, and ask questions. Community guidelines are enforced to keep discussions productive and spam-free.'],
            ['id' => 6, 'q' => 'Is FinPulse suitable for complete beginners?', 'a' => 'Yes. Our beginner modules assume zero prior financial knowledge and walk you through everything step by step.'],
        ];
    @endphp

    <section id="faq" class="py-24 relative overflow-hidden bg-white font-['DM_Sans',sans-serif]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" x-data="{
                     activeId: null,
                     toggle(id) {
                         this.activeId = this.activeId === id ? null : id;
                     }
                 }">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-14 reveal-item">

                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">
                    Frequently Asked Questions. <br class="hidden sm:inline" /><em class="not-italic text-[#00C48C]">We
                        Have Answers.</em>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#00C48C] to-[#00A86B] rounded-full mx-auto mt-4"></div>
            </div>

            <!-- FAQ Accordion -->
            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <div class="reveal-item rounded-2xl overflow-hidden border bg-white transition-all duration-300"
                        :class="activeId === {{ $faq['id'] }} ? 'border-[#00C48C]/50 shadow-lg' : 'border-slate-200 hover:border-slate-300'">
                        <button @click="toggle({{ $faq['id'] }})"
                            class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer group"
                            :aria-expanded="activeId === {{ $faq['id'] }} ? 'true' : 'false'"
                            aria-controls="faq-ans-{{ $faq['id'] }}" id="faq-btn-{{ $faq['id'] }}">
                            <span
                                class="text-sm sm:text-base font-semibold text-[#0F172A] leading-snug group-hover:text-[#00C48C] transition-colors">
                                {{ $faq['q'] }}
                            </span>

                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-all duration-300"
                                :class="activeId === {{ $faq['id'] }} ? 'bg-[#00C48C] text-white rotate-45 shadow-sm' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14m7-7H5" />
                                </svg>
                            </div>
                        </button>

                        <div id="faq-ans-{{ $faq['id'] }}" role="region" aria-labelledby="faq-btn-{{ $faq['id'] }}"
                            x-show="activeId === {{ $faq['id'] }}" x-collapse x-cloak class="border-t border-slate-100">
                            <div class="px-6 pb-5 pt-4 text-sm sm:text-base text-[#475569] leading-relaxed">
                                <p>{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




    <!-- =====================================================
             SECTION 9 — BOTTOM CTA BANNER (CURVED EMERALD THEME)
             ===================================================== -->
    <section class="py-20 relative overflow-hidden bg-white fp-cta-section font-['DM_Sans',sans-serif]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="rounded-3xl bg-gradient-to-r from-[#00D084] to-[#00A86B] p-10 sm:p-16 text-center text-white relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/20 rounded-full blur-3xl pointer-events-none">
                </div>

                <div class="max-w-3xl mx-auto text-center relative z-10 space-y-6 reveal-item">


                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                        Your Investing Journey Starts Today.
                    </h2>
                    <p class="text-base sm:text-lg text-emerald-50 max-w-xl mx-auto leading-relaxed">
                        Join thousands of retail investors mastering financial literacy and building wealth.
                    </p>
                    @if (Route::has('register'))
                        <div>
                            <a href="{{ route('register') }}" wire:navigate
                                class="inline-block px-12 py-4 bg-[#0B132B] hover:bg-black text-white font-black text-base rounded-full shadow-2xl hover:scale-105 transition-all">
                                Join Free
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <!-- =====================================================
             SECTION 10 — FOOTER (PREMIUM DARK FOREST GREEN DESIGN)
             ===================================================== -->
    <footer
        class="relative overflow-hidden font-['DM_Sans',sans-serif] bg-[#061A14] text-white border-t border-emerald-950">
        <!-- Subtle grid pattern overlay -->
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
            style="opacity:0.04; background-image: linear-gradient(rgba(0,196,140,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(0,196,140,0.3) 1px, transparent 1px); background-size: 60px 60px;">
        </div>

        <!-- Main Footer Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

                <!-- Left Column: Logo + Description + Socials -->
                <div class="md:col-span-4 space-y-6">
                    <!-- Logo -->
                    <a href="/" wire:navigate class="inline-flex items-center gap-3 group" aria-label="FinPulse Home">
                        <div
                            class="w-8 h-8 rounded-lg bg-[#00C48C] flex items-center justify-center text-white font-black shadow-md shadow-[#00C48C]/30">
                            FP
                        </div>
                        <span class="font-bold text-xl text-white">Fin<span class="text-[#00C48C]">Pulse</span></span>
                    </a>

                    <!-- Description -->
                    <p class="text-sm text-slate-400 leading-relaxed max-w-xs">
                        FinPulse helps you invest smarter by transforming financial education into actionable,
                        easy-to-follow insights.
                    </p>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-4 pt-1">
                        <a href="#" aria-label="Twitter / X"
                            class="text-slate-400 hover:text-[#00C48C] transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="GitHub"
                            class="text-slate-400 hover:text-[#00C48C] transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                            </svg>
                        </a>
                        <a href="#" aria-label="LinkedIn"
                            class="text-slate-400 hover:text-[#00C48C] transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="YouTube"
                            class="text-slate-400 hover:text-[#00C48C] transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram"
                            class="text-slate-400 hover:text-[#00C48C] transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Link Columns Container -->
                <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-3 gap-10 lg:gap-16">
                    <!-- Column 1: Platform -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-5">Platform</h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Community
                                    Feed</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Stock
                                    Research</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Learning
                                    Modules</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Market
                                    Watchlist</a></li>
                        </ul>
                    </div>

                    <!-- Column 2: Resources -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-5">Resources</h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Blog</a>
                            </li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Research
                                    Library</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Webinars</a>
                            </li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Newsletters</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 3: Company -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-5">Company</h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">About
                                    Us</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Careers</a>
                            </li>
                            <li><a href="{{ route('privacy') }}"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Privacy
                                    Policy</a></li>
                            <li><a href="{{ route('terms') }}"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Terms
                                    of Service</a></li>
                            <li><a href="#"
                                    class="text-sm text-slate-400 hover:text-[#00C48C] transition-colors duration-200">Contact
                                    Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Divider + Copyright Bar -->
            <div
                class="mt-14 pt-7 border-t border-emerald-900/40 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
                <p class="text-slate-400">&copy; {{ date('Y') }} FinPulse Pakistan. All rights reserved.</p>
                <p class="text-slate-400">Registered financial literacy &amp; market intelligence.</p>
            </div>
        </div>

        <!-- Large Watermark Brand Text -->
        <div class="relative z-0 overflow-hidden select-none pointer-events-none" aria-hidden="true"
            style="margin-top: -30px;">
            <div class="max-w-[100vw] flex items-end justify-center" style="height: 150px;">
                <span class="whitespace-nowrap text-white text-[min(14vw,160px)] font-black tracking-tight leading-none"
                    style="color: transparent; -webkit-text-stroke: 1.5px rgba(0, 196, 140, 0.3); text-stroke: 1.5px rgba(0, 196, 140, 0.3);">
                    FinPulse
                </span>
            </div>
            <!-- Bottom gradient fade -->
            <div class="relative bottom-0 left-0 right-0 h-12"
                style="background: linear-gradient(to top, #061A14, transparent);"></div>
        </div>
    </footer>


    <!-- =====================================================
             INLINE SCRIPTS
             ===================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // ============================================================
            // SMOOTH SCROLL
            // ============================================================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href').slice(1);
                    const target = document.getElementById(targetId);
                    if (!target) return;
                    e.preventDefault();
                    const navHeight = document.getElementById('nx-hero-nav')?.offsetHeight ?? 72;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({ top, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
                });
            });

            if (prefersReducedMotion) {
                document.querySelectorAll('.reveal-item').forEach(el => el.classList.add('revealed'));
                document.querySelectorAll('.stat-number').forEach(el => {
                    const parent = el.closest('[data-target]');
                    if (parent) el.textContent = parseInt(parent.getAttribute('data-target')).toLocaleString() + (parent.getAttribute('data-suffix') || '');
                });
                const pl = document.getElementById('step-progress-line');
                if (pl) pl.style.width = '100%';
                return;
            }

            // ============================================================
            // GSAP SETUP — Register all plugins
            // ============================================================
            gsap.registerPlugin(ScrollTrigger, Observer, MotionPathPlugin);

            // ============================================================
            // GSAP CONTEXT — clean Livewire-safe scope
            // ============================================================
            const ctx = gsap.context(() => {

                // ============================================================
                // HERO PIN + SEQUENCED TIMELINE
                // ============================================================
                const heroSection = document.getElementById('nx-hero');
                const heroNav = document.getElementById('nx-hero-nav');
                const heroContent = document.getElementById('nx-hero-content');
                const heroFooter = document.getElementById('nx-hero-footer');
                const heroVideo = document.getElementById('nx-hero-video');
                const heroGrid = document.getElementById('nx-hero-grid');
                const heroDot = document.getElementById('hero-dot');

                if (heroSection && heroNav && heroContent) {
                    // Initial states for hero entrance
                    gsap.set([heroNav, heroContent, heroFooter].filter(Boolean), { opacity: 0, y: 30 });
                    gsap.set(heroVideo, { scale: 1.15, opacity: 0 });
                    gsap.set(heroGrid, { opacity: 0 });

                    // Hero entrance timeline (plays on page load)
                    const heroTL = gsap.timeline({ defaults: { ease: 'power3.out' } });
                    heroTL
                        .to(heroVideo, { scale: 1.06, opacity: 1, duration: 1.2, ease: 'power2.out' }, 0)
                        .to(heroGrid, { opacity: 0.22, duration: 1 }, 0.3)
                        .to(heroNav, { opacity: 1, y: 0, duration: 0.7 }, 0.2)
                        .to(heroContent, { opacity: 1, y: 0, duration: 0.8 }, 0.4)
                        .to(heroFooter, { opacity: 1, y: 0, duration: 0.7 }, 0.7);

                    // Pin hero section on scroll with parallax out (Desktop only)
                    if (window.innerWidth >= 1024) {
                        ScrollTrigger.create({
                            trigger: heroSection,
                            start: 'top top',
                            end: '+=100%',
                            pin: true,
                            pinSpacing: false,
                        });
                    }

                    // Hero parallax layers on scroll
                    gsap.to(heroVideo, {
                        scale: 1.2,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: heroSection,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: 1.5,
                        },
                    });

                    gsap.to(heroGrid, {
                        y: -100,
                        opacity: 0,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: heroSection,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: 1,
                        },
                    });

                    // Hero content fade out on scroll
                    gsap.to(heroContent, {
                        y: -60,
                        opacity: 0,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: heroSection,
                            start: '30% top',
                            end: 'bottom top',
                            scrub: 1,
                        },
                    });

                    // MotionPath — animate dot along SVG path
                    if (heroDot) {
                        gsap.fromTo(heroDot,
                            { opacity: 0 },
                            {
                                opacity: 1,
                                duration: 0.5,
                                delay: 1.5,
                                ease: 'power2.out',
                            }
                        );
                        gsap.to(heroDot, {
                            motionPath: {
                                path: '#hero-path',
                                align: '#hero-path',
                                alignOrigin: [0.5, 0.5],
                                autoRotate: false,
                            },
                            duration: 8,
                            ease: 'none',
                            repeat: -1,
                            yoyo: true,
                        });
                    }
                }

                // ============================================================
                // SCROLL PROGRESS BAR — using GSAP quickTo
                // ============================================================
                const scrollProgressEl = document.getElementById('scroll-progress');
                if (scrollProgressEl) {
                    const updateProgress = gsap.quickTo(scrollProgressEl, 'width', {
                        duration: 0.2,
                        ease: 'power2.out',
                    });
                    window.addEventListener('scroll', () => {
                        const scrollTop = window.pageYOffset;
                        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                        updateProgress((scrollTop / docHeight) * 100 + '%');
                    });
                }

                // ============================================================
                // HERO WORD REVEAL
                // ============================================================
                const heroLines = document.querySelectorAll('[data-hero-line]');
                let delay = 0.05;
                const PER_WORD_DELAY = 0.08;
                heroLines.forEach(line => {
                    const nodes = Array.from(line.childNodes);
                    const newHTML = nodes.map(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            return node.textContent.split(/(\s+)/).map(part => {
                                if (!part.trim()) return part;
                                const span = `<span class="word-reveal" style="animation-delay:${delay.toFixed(2)}s;">${part}</span>`;
                                delay += PER_WORD_DELAY;
                                return span;
                            }).join('');
                        } else if (node.nodeType === Node.ELEMENT_NODE) {
                            const words = node.textContent.split(/(\s+)/);
                            const inner = words.map(w => {
                                if (!w.trim()) return w;
                                const span = `<span class="word-reveal" style="animation-delay:${delay.toFixed(2)}s;color:inherit;">${w}</span>`;
                                delay += PER_WORD_DELAY;
                                return span;
                            }).join('');
                            return `<span class="text-[#0A0A0A]">${inner}</span>`;
                        }
                        return '';
                    }).join('');
                    line.innerHTML = newHTML;
                });

                // ============================================================
                // SCROLL-TRIGGERED SECTION ANIMATIONS — using batch for performance
                // ============================================================
                ScrollTrigger.batch('.reveal-item', {
                    start: 'top 88%',
                    once: true,
                    onEnter: (batch) => {
                        gsap.fromTo(batch,
                            { opacity: 0, y: 40 },
                            {
                                opacity: 1, y: 0,
                                duration: 0.8,
                                stagger: 0.1,
                                ease: 'power3.out',
                                overwrite: true,
                            }
                        );
                    },
                });

                // ============================================================
                // PARALLAX SECTIONS — subtle depth on scroll
                // ============================================================
                gsap.utils.toArray('.fp-parallax-section').forEach(section => {
                    const bg = section.querySelector('.fp-parallax-bg');
                    if (bg) {
                        gsap.to(bg, {
                            y: -60,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: section,
                                start: 'top bottom',
                                end: 'bottom top',
                                scrub: 1,
                            },
                        });
                    }
                });

                // About section 3D mockup parallax
                const mockupContainer = document.querySelector('.perspective-1000');
                if (mockupContainer) {
                    gsap.fromTo(mockupContainer,
                        { rotateX: 12, scale: 0.92, opacity: 0 },
                        {
                            rotateX: 0, scale: 1, opacity: 1,
                            ease: 'power2.out',
                            scrollTrigger: {
                                trigger: mockupContainer,
                                start: 'top 85%',
                                end: 'top 20%',
                                scrub: 1,
                            },
                        }
                    );
                }

                // ============================================================
                // MAGNETIC BUTTONS — using gsap.quickTo for high performance
                // ============================================================
                document.querySelectorAll('.fp-magnetic').forEach(btn => {
                    const magneticX = gsap.quickTo(btn, 'x', { duration: 0.3, ease: 'power2.out' });
                    const magneticY = gsap.quickTo(btn, 'y', { duration: 0.3, ease: 'power2.out' });

                    btn.addEventListener('mousemove', (e) => {
                        const rect = btn.getBoundingClientRect();
                        const x = (e.clientX - rect.left - rect.width / 2) * 0.3;
                        const y = (e.clientY - rect.top - rect.height / 2) * 0.3;
                        magneticX(x);
                        magneticY(y);
                    });
                    btn.addEventListener('mouseleave', () => {
                        gsap.to(btn, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.3)' });
                    });
                });

                // ============================================================
                // TEXT SCRAMBLE EFFECT ON HEADINGS
                // ============================================================
                const chars = '!<>-_\\/[]{}—=+*^?#________';
                function scrambleText(el) {
                    const original = el.getAttribute('data-text') || el.textContent;
                    el.setAttribute('data-text', original);
                    let iteration = 0;
                    const interval = setInterval(() => {
                        el.textContent = original.split('').map((char, index) => {
                            if (index < iteration) return original[index];
                            return chars[Math.floor(Math.random() * chars.length)];
                        }).join('');
                        if (iteration >= original.length) clearInterval(interval);
                        iteration += 1 / 2;
                    }, 25);
                }

                document.querySelectorAll('.fp-scramble').forEach(el => {
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 85%',
                        once: true,
                        onEnter: () => scrambleText(el),
                    });
                });

                // ============================================================
                // FLOATING PARTICLES
                // ============================================================
                const particlesContainer = document.getElementById('hero-particles');
                if (particlesContainer) {
                    for (let i = 0; i < 20; i++) {
                        const particle = document.createElement('div');
                        particle.className = 'fp-particle';
                        particle.style.left = Math.random() * 100 + '%';
                        particle.style.top = Math.random() * 100 + '%';
                        particle.style.width = (Math.random() * 4 + 2) + 'px';
                        particle.style.height = particle.style.width;
                        particle.style.animationDuration = (Math.random() * 10 + 8) + 's';
                        particle.style.animationDelay = (Math.random() * 5) + 's';
                        particle.style.opacity = Math.random() * 0.3 + 0.1;
                        particlesContainer.appendChild(particle);
                    }
                }

                // ============================================================
                // CURSOR FOLLOWER — using gsap.quickTo for 60fps
                // ============================================================
                const cursorDot = document.getElementById('cursor-dot');
                if (cursorDot && window.innerWidth > 768) {
                    const cursorX = gsap.quickTo(cursorDot, 'left', { duration: 0.15, ease: 'power3.out' });
                    const cursorY = gsap.quickTo(cursorDot, 'top', { duration: 0.15, ease: 'power3.out' });

                    document.addEventListener('mousemove', (e) => {
                        cursorX(e.clientX - 4);
                        cursorY(e.clientY - 4);
                        cursorDot.classList.add('active');
                    });
                    document.querySelectorAll('a, button, .tilt-card, .fp-magnetic').forEach(el => {
                        el.addEventListener('mouseenter', () => cursorDot.classList.add('hovering'));
                        el.addEventListener('mouseleave', () => cursorDot.classList.remove('hovering'));
                    });
                }

                // ============================================================
                // ENHANCED 3D TILT ON CARDS
                // ============================================================
                if (window.innerWidth > 768) {
                    document.querySelectorAll('.tilt-card').forEach(card => {
                        const tiltX = gsap.quickTo(card, 'rotateX', { duration: 0.4, ease: 'power2.out' });
                        const tiltY = gsap.quickTo(card, 'rotateY', { duration: 0.4, ease: 'power2.out' });
                        const tiltScale = gsap.quickTo(card, 'scale', { duration: 0.4, ease: 'power2.out' });

                        card.addEventListener('mousemove', (e) => {
                            const rect = card.getBoundingClientRect();
                            const cx = rect.left + rect.width / 2;
                            const cy = rect.top + rect.height / 2;
                            const dx = (e.clientX - cx) / (rect.width / 2);
                            const dy = (e.clientY - cy) / (rect.height / 2);
                            const maxAngle = 8;
                            tiltX(-dy * maxAngle);
                            tiltY(dx * maxAngle);
                            tiltScale(1.03);
                            gsap.set(card, { transformPerspective: 600 });
                        });
                        card.addEventListener('mouseleave', () => {
                            tiltX(0);
                            tiltY(0);
                            tiltScale(1);
                        });
                    });
                }

                // ============================================================
                // PROGRESS LINE — How It Works
                // ============================================================
                const progressLine = document.getElementById('step-progress-line');
                if (progressLine) {
                    gsap.to(progressLine, {
                        width: '100%',
                        duration: 1.5,
                        ease: 'power2.inOut',
                        scrollTrigger: {
                            trigger: '#how-it-works',
                            start: 'top 60%',
                            once: true,
                        },
                    });
                }

                // ============================================================
                // STATS COUNTER with GSAP
                // ============================================================
                document.querySelectorAll('[data-target]').forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'), 10);
                    const suffix = counter.getAttribute('data-suffix') || '';
                    const numSpan = counter.querySelector('.stat-number');
                    if (!numSpan) return;

                    const obj = { val: 0 };
                    gsap.to(obj, {
                        val: target,
                        duration: 2,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: counter,
                            start: 'top 80%',
                            once: true,
                        },
                        onUpdate: () => {
                            numSpan.textContent = Math.floor(obj.val).toLocaleString() + suffix;
                        },
                    });
                });

                // ============================================================
                // GSAP STAGGER on Bento Grid tiles — using batch
                // ============================================================
                const bentoTiles = document.querySelectorAll('#features .reveal-item');
                if (bentoTiles.length) {
                    ScrollTrigger.batch(bentoTiles, {
                        start: 'top 80%',
                        once: true,
                        onEnter: (batch) => {
                            gsap.fromTo(batch,
                                { opacity: 0, y: 50, scale: 0.95 },
                                {
                                    opacity: 1, y: 0, scale: 1,
                                    duration: 0.6,
                                    stagger: 0.1,
                                    ease: 'power3.out',
                                    overwrite: true,
                                }
                            );
                        },
                    });
                }

                // ============================================================
                // PRICING CARDS — scale entrance
                // ============================================================
                const pricingCards = document.querySelectorAll('#pricing .reveal-item');
                if (pricingCards.length) {
                    ScrollTrigger.batch(pricingCards, {
                        start: 'top 80%',
                        once: true,
                        onEnter: (batch) => {
                            gsap.fromTo(batch,
                                { opacity: 0, y: 40, scale: 0.9 },
                                {
                                    opacity: 1, y: 0, scale: 1,
                                    duration: 0.7,
                                    stagger: 0.15,
                                    ease: 'back.out(1.4)',
                                    overwrite: true,
                                }
                            );
                        },
                    });
                }

                // ============================================================
                // FAQ ITEMS — slide in from left
                // ============================================================
                const faqItems = document.querySelectorAll('#faq .reveal-item');
                if (faqItems.length) {
                    ScrollTrigger.batch(faqItems, {
                        start: 'top 80%',
                        once: true,
                        onEnter: (batch) => {
                            gsap.fromTo(batch,
                                { opacity: 0, x: -30 },
                                {
                                    opacity: 1, x: 0,
                                    duration: 0.5,
                                    stagger: 0.08,
                                    ease: 'power2.out',
                                    overwrite: true,
                                }
                            );
                        },
                    });
                }

                // ============================================================
                // BOTTOM CTA — dramatic scale entrance
                // ============================================================
                const ctaSection = document.querySelector('.fp-cta-section');
                if (ctaSection) {
                    gsap.fromTo(ctaSection.querySelector('.max-w-3xl'),
                        { opacity: 0, y: 60, scale: 0.92 },
                        {
                            opacity: 1, y: 0, scale: 1,
                            duration: 1,
                            ease: 'power3.out',
                            scrollTrigger: {
                                trigger: ctaSection,
                                start: 'top 70%',
                                once: true,
                            },
                        }
                    );
                }

                // ============================================================
                // FOOTER — fade up
                // ============================================================
                const footer = document.querySelector('footer');
                if (footer) {
                    gsap.fromTo(footer,
                        { opacity: 0 },
                        {
                            opacity: 1,
                            duration: 0.8,
                            ease: 'power2.out',
                            scrollTrigger: {
                                trigger: footer,
                                start: 'top 95%',
                                once: true,
                            },
                        }
                    );
                }

                // ============================================================
                // OBSERVER — Scroll direction nav hide/show
                // ============================================================
                const mainNav = document.getElementById('nx-hero-nav');
                if (mainNav && window.innerWidth > 768) {
                    let lastScrollTop = 0;
                    Observer.create({
                        type: 'scroll',
                        onUp: () => {
                            const st = window.pageYOffset;
                            if (st > lastScrollTop && st > 200) {
                                mainNav.classList.add('fp-nav-hidden');
                                mainNav.classList.remove('fp-nav-visible');
                            }
                            lastScrollTop = st <= 0 ? 0 : st;
                        },
                        onDown: () => {
                            const st = window.pageYOffset;
                            if (st < lastScrollTop) {
                                mainNav.classList.remove('fp-nav-hidden');
                                mainNav.classList.add('fp-nav-visible');
                            }
                            lastScrollTop = st <= 0 ? 0 : st;
                        },
                        wheel: true,
                        touch: true,
                    });
                }

                // ============================================================
                // OBSERVER — Mobile swipe carousel for sample content
                // ============================================================
                const sampleCarousel = document.querySelector('.snap-x');
                if (sampleCarousel && window.innerWidth < 768) {
                    Observer.create({
                        target: sampleCarousel,
                        type: 'touch',
                        onLeft: () => sampleCarousel.scrollBy({ left: 300, behavior: 'smooth' }),
                        onRight: () => sampleCarousel.scrollBy({ left: -300, behavior: 'smooth' }),
                        tolerance: 10,
                        preventDefault: true,
                    });
                }

                // ============================================================
                // MATCHMEDIA — Responsive breakpoint animations
                // ============================================================
                const mm = gsap.matchMedia();

                mm.add('(min-width: 1024px)', () => {
                    // Desktop-only: full hero pin with parallax
                    return () => { };
                });

                mm.add('(max-width: 767px)', () => {
                    // Mobile-only: simplified hero (no pin, no magnetic)
                    if (heroSection) {
                        ScrollTrigger.getAll().forEach(st => {
                            if (st.trigger === heroSection) st.kill();
                        });
                    }
                    return () => { };
                });

                mm.add('(prefers-reduced-motion: reduce)', () => {
                    // Kill all animations for reduced motion
                    gsap.globalTimeline.clear();
                    ScrollTrigger.getAll().forEach(st => st.kill());
                    return () => { };
                });

            }); // end gsap.context

        });
    </script>
</body>

</html>