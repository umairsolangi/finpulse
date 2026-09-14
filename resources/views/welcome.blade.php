<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth" style="background-color: #071a12 !important; background: #071a12 !important; margin: 0; padding: 0;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="FinPulse is Pakistan's premier financial education platform. Learn market fundamentals, track your money, and invest with confidence. Free to join.">

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
    </head>
    <body
        x-data="{
            scrolled: false,
            mobileOpen: false,
            activeMockup: 0,
        }"
        @scroll.window="scrolled = (window.pageYOffset > 80)"
        class="font-sans antialiased text-[#b6c0e7] bg-[#071a12] min-h-screen selection:bg-[#4e5bff] selection:text-white relative overflow-x-hidden"
        style="background-color: #071a12 !important; background: #071a12 !important; margin: 0; padding: 0;"
        id="page-top"
    >
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
             SECTION 2 — ABOUT FINPULSE (LIGHT MODE SHOWCASE)
             ===================================================== -->
        <section id="about" class="py-24 relative overflow-hidden bg-[#F8F9FA] text-[#0F172A] font-['DM_Sans',sans-serif] fp-parallax-section">
            <!-- Light Grid Background Overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-40 z-0" aria-hidden="true" style="background-image: linear-gradient(rgba(100, 116, 139, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.1) 1px, transparent 1px); background-size: 80px 80px;"></div>

            <!-- Soft Ambient Glow -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-gradient-to-r from-[#4e5bff]/10 to-[#903dff]/10 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Centered Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-14 reveal-item">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-[0.18em] text-[#4e5bff] bg-[#4e5bff]/10 border border-[#4e5bff]/20 backdrop-blur-md mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#4e5bff] animate-pulse"></span>
                        Platform Showcase
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#0F172A] tracking-tight leading-tight">
                        See FinPulse in <em class="not-italic text-[#4e5bff]">Action</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base sm:text-lg text-[#475569] max-w-2xl mx-auto leading-relaxed">
                        Discover how our structured learning, active investor community, and actionable financial insights empower you to make smarter market decisions.
                    </p>
                </div>

                <!-- 3D Scroll-Animated Browser Mockup Box -->
                <div
                    x-data="{
                        scrollProgress: 0,
                        updateProgress() {
                            const rect = $el.getBoundingClientRect();
                            const winH = window.innerHeight;
                            const progress = Math.min(Math.max((winH - rect.top) / (winH + rect.height), 0), 1);
                            this.scrollProgress = progress;
                        }
                    }"
                    @scroll.window="updateProgress()"
                    x-init="updateProgress()"
                    class="max-w-5xl mx-auto perspective-1000 reveal-item"
                >
                    <div
                        class="transition-all duration-300 ease-out transform rounded-2xl overflow-hidden shadow-[0_20px_50px_rgba(15,23,42,0.12)] border border-slate-200 bg-white"
                        :style="`transform: perspective(1000px) rotateX(${(1 - scrollProgress) * 10}deg) scale(${0.92 + (scrollProgress * 0.08)}); opacity: ${Math.min(scrollProgress * 1.4, 1)};`"
                    >
                        <!-- Browser Header Window Bar -->
                        <div class="px-5 py-3.5 bg-[#0F172A] border-b border-slate-800 flex items-center justify-between gap-4">
                            <!-- Left: Window Control Buttons -->
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                            </div>

                            <!-- Center: URL Pill Address Bar -->
                            <div class="flex-1 max-w-sm mx-auto bg-slate-800/90 border border-slate-700 rounded-lg px-3 py-1 text-xs text-slate-300 flex items-center justify-center gap-2 font-mono">
                                <svg class="w-3.5 h-3.5 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>finpulse.pk / platform-demo</span>
                            </div>

                            <!-- Right: Window Label -->
                            <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                <span>FinPulse Platform Showcase</span>
                            </div>
                        </div>

                        <!-- Video Showcase Box (Behaves like a GIF) -->
                        <div class="relative aspect-video bg-black overflow-hidden select-none" oncontextmenu="return false;">
                            <video
                                class="w-full h-full object-cover pointer-events-none"
                                autoplay
                                muted
                                loop
                                playsinline
                                disablePictureInPicture
                                disableremoteplayback
                                preload="auto"
                                aria-hidden="true"
                                tabindex="-1"
                            >
                                <source src="{{ asset('about.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            <!-- Transparent overlay to prevent any interaction or right click menu -->
                            <div class="absolute inset-0 z-10 bg-transparent pointer-events-auto cursor-default"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Features Quick Badges -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto mt-16 reveal-item">
                    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-md text-center hover:border-[#4e5bff]/50 hover:shadow-xl transition-all duration-300">
                        <div class="text-3xl mb-3">🎓</div>
                        <h3 class="font-bold text-[#0F172A] text-base mb-1">Structured Courses</h3>
                        <p class="text-xs text-[#475569]">Step-by-step financial modules built for all experience levels.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-md text-center hover:border-[#4e5bff]/50 hover:shadow-xl transition-all duration-300">
                        <div class="text-3xl mb-3">👥</div>
                        <h3 class="font-bold text-[#0F172A] text-base mb-1">Active Community</h3>
                        <p class="text-xs text-[#475569]">Real-time market discussions, discussions, and investor networking.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-md text-center hover:border-[#4e5bff]/50 hover:shadow-xl transition-all duration-300">
                        <div class="text-3xl mb-3">📈</div>
                        <h3 class="font-bold text-[#0F172A] text-base mb-1">Actionable Insights</h3>
                        <p class="text-xs text-[#475569]">Data-driven research and fundamental metrics for real results.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             SECTION 3 — HOW IT WORKS
             ===================================================== -->
        <section id="how-it-works" class="pt-20 pb-28 relative overflow-hidden bg-[#07113d] font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-10 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        Three Steps. One Goal: <br class="sm:hidden"/><em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">A Smarter Investor.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-4 text-base text-[#b6c0e7] max-w-xl mx-auto">
                        A structured path designed to take you from market beginner to confident investor.
                    </p>
                </div>

                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                    <!-- Desktop connecting line (aligned through circle centers) -->
                    <div class="hidden md:block absolute top-[64px] left-[calc(16.67%+20px)] right-[calc(16.67%+20px)] h-0.5 bg-[#889eff]/20 z-0 pointer-events-none" aria-hidden="true">
                        <div id="step-progress-line" class="h-full bg-gradient-to-r from-[#4e5bff] to-[#903dff] transition-all duration-1000 ease-out" style="width:0%"></div>
                    </div>

                    <!-- Step 01 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300 h-full" style="--stagger:1;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)] shrink-0">
                            <span class="text-white text-2xl font-black">1</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 01</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Join the Community</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed flex-1">
                            Ask questions, follow market discussions, and learn from others — completely free.
                        </p>
                    </div>

                    <!-- Step 02 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300 h-full" style="--stagger:2;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)] shrink-0">
                            <span class="text-white text-2xl font-black">2</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 02</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Learn with Structure</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed flex-1">
                            Work through courses built for beginners to advanced investors, at your own pace.
                        </p>
                    </div>

                    <!-- Step 03 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300 h-full" style="--stagger:3;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)] shrink-0">
                            <span class="text-white text-2xl font-black">3</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 03</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Grow with Confidence</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed flex-1">
                            Unlock premium research, live sessions, and a guided path to your first investment.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             SECTION 4 — FEATURES (BENTO GRID LIGHT MODE)
             ===================================================== -->
        <section id="features" class="py-24 bg-[#F1F5F9] relative font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight">
                        Everything You Need, <em class="not-italic text-[#4e5bff]">In One Place.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#475569]">
                        Tools and resources tailored specifically for retail financial education.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Large Tile: Community Feed -->
                    <div class="reveal-item group relative bg-white rounded-2xl p-8 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#4e5bff]/50 md:hover:shadow-xl
                                sm:col-span-2 lg:col-span-2 lg:row-span-2">
                        <div class="absolute top-6 right-6 flex gap-1.5" aria-hidden="true">
                            <div class="w-7 h-7 rounded-full bg-[#4e5bff]/15 border border-[#4e5bff]/30 animate-badge-pulse" style="animation-delay:0s;"></div>
                            <div class="w-7 h-7 rounded-full bg-[#903dff]/15 border border-[#903dff]/30 animate-badge-pulse" style="animation-delay:0.4s;"></div>
                            <div class="w-7 h-7 rounded-full bg-[#4e5bff]/10 border border-[#4e5bff]/20 animate-badge-pulse" style="animation-delay:0.8s;"></div>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-md group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0F172A] mb-2">Community Feed</h3>
                        <p class="text-sm text-[#475569] leading-relaxed max-w-xs">Real conversations with real investors.</p>
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
                    <div class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#4e5bff]/50 md:hover:shadow-xl">
                        <div class="absolute top-5 right-5" aria-hidden="true">
                            <svg class="w-12 h-12 opacity-30 group-hover:opacity-60 transition-opacity duration-200" viewBox="0 0 36 36" fill="none">
                                <circle cx="18" cy="18" r="15.9" stroke="#4e5bff" stroke-width="3" stroke-dasharray="75 25" stroke-dashoffset="25" transform="rotate(-90 18 18)"/>
                            </svg>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-5 shadow-md group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2">Courses &amp; Certificates</h3>
                        <p class="text-sm text-[#475569] leading-relaxed">Structured learning you can show off.</p>
                    </div>

                    <!-- Tile: Live Sessions -->
                    <div class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#4e5bff]/50 md:hover:shadow-xl">
                        <div class="absolute top-5 right-5 flex items-center gap-1.5" aria-hidden="true">
                            <span class="live-dot w-2.5 h-2.5 rounded-full bg-[#4e5bff] block animate-pulse"></span>
                            <span class="text-xs font-bold text-[#4e5bff] uppercase tracking-wider">Live</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-5 shadow-md group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2">Live Sessions</h3>
                        <p class="text-sm text-[#475569] leading-relaxed">Get your questions answered, live.</p>
                    </div>

                    <!-- Tile: Premium Research -->
                    <div class="reveal-item group relative bg-white rounded-2xl p-7 border border-slate-200/90 shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#4e5bff]/50 md:hover:shadow-xl
                                sm:col-span-2 lg:col-span-3">
                        <div class="absolute top-5 right-6" aria-hidden="true">
                            <svg class="w-8 h-8 text-slate-300 group-hover:text-[#4e5bff] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-0 shadow-md shrink-0 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-[#0F172A] mb-2">Premium Research</h3>
                                <p class="text-sm text-[#475569] leading-relaxed">Insights the free internet won't give you.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- =====================================================
             SECTION — BROWSE COMMUNITY BY TOPIC (LIGHT MODE)
             ===================================================== -->
        <section id="community-topics" class="py-20 lg:py-24 relative overflow-hidden bg-[#F8FAFC] font-['DM_Sans',sans-serif] border-t border-slate-200" style="background-color: #F8FAFC !important; color: #0F172A !important;">
            <!-- Subtle Light Background Grid -->
            <div class="absolute inset-0 pointer-events-none opacity-40 z-0" aria-hidden="true" style="background-image: linear-gradient(rgba(100, 116, 139, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.07) 1px, transparent 1px); background-size: 64px 64px;"></div>

            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Section Header -->
                <div class="mb-14 text-center max-w-2xl mx-auto reveal-item">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-[0.18em] text-[#4e5bff] bg-[#4e5bff]/10 border border-[#4e5bff]/20 mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#4e5bff] animate-pulse"></span>
                        Community Topics
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0F172A] tracking-tight">
                        Browse the Community <em class="not-italic text-[#4e5bff]">by Topic.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-4 text-base sm:text-lg text-[#475569] leading-relaxed">
                        Jump straight into the discussions that matter to you.
                    </p>
                </div>

                <!-- 4 Topic Cards Grid (Pure Light Mode) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Stocks Card -->
                    <a href="{{ route('feed', ['category' => 'stocks']) }}" wire:navigate class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#4e5bff]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img alt="Stocks - Candlestick chart and market trading data" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('images/topics/stocks.jpg') }}">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#4e5bff] shadow-sm border border-slate-200/80">
                                    Equities
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#4e5bff] transition-colors">
                                    Stocks
                                </h3>
                                <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                    Market fundamentals, earnings reports, and KSE-100 movements.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#4e5bff]">
                                <span>Explore Discussions</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Mutual Funds Card -->
                    <a href="{{ route('feed', ['category' => 'mutual_funds']) }}" wire:navigate class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#4e5bff]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img alt="Mutual Funds - Wealth management and portfolio allocation" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('images/topics/mutual_funds.jpg') }}">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#4e5bff] shadow-sm border border-slate-200/80">
                                    Funds &amp; Wealth
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#4e5bff] transition-colors">
                                    Mutual Funds
                                </h3>
                                <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                    Portfolio growth, fund allocation, and managed investment strategies.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#4e5bff]">
                                <span>Explore Discussions</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Basics Card -->
                    <a href="{{ route('feed', ['category' => 'basics']) }}" wire:navigate class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#C89B3C]/60 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img alt="Basics - Investment literacy and beginner fundamentals" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('images/topics/basics.jpg') }}">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#B38022] shadow-sm border border-slate-200/80">
                                    Beginner
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#B38022] transition-colors">
                                    Basics
                                </h3>
                                <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                    Budgeting rules, financial literacy, and first investment steps.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#B38022]">
                                <span>Explore Discussions</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- News Card -->
                    <a href="{{ route('feed', ['category' => 'news']) }}" wire:navigate class="reveal-item group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#4e5bff]/50 hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img alt="News - Financial market press and economic updates" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('images/topics/news.jpg') }}">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#4e5bff] shadow-sm border border-slate-200/80">
                                    Market News
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-[#0F172A] group-hover:text-[#4e5bff] transition-colors">
                                    News
                                </h3>
                                <p class="mt-1 text-xs text-[#64748B] leading-relaxed">
                                    Daily financial headlines, economic data, and policy updates.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#4e5bff]">
                                <span>Explore Discussions</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>


        <!-- =====================================================
             SECTION 5 — SAMPLE CONTENT PREVIEW
             ===================================================== -->
        <section class="py-24 relative overflow-hidden bg-[#07113d] font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        A Taste of <em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">What You'll Learn.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#b6c0e7]">
                        Explore sample topics from our fundamental investment curriculum.
                    </p>
                </div>

                <div class="flex overflow-x-auto gap-5 pb-4 sm:pb-0 md:grid md:grid-cols-2 lg:grid-cols-4 snap-x snap-mandatory -mx-4 px-4 sm:mx-0 sm:px-0">
                    <div class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#4e5bff]/20 text-[#aebaff] border border-[#889eff]/30 mb-4">Beginner</span>
                            <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">What is a P/E Ratio?</h3>
                            <p class="text-xs text-[#b6c0e7] leading-relaxed">Learn how price-to-earnings ratios help evaluate stock valuations.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#889eff]/20 flex items-center justify-between text-xs font-semibold text-[#6d80ff]">
                            <span>Module 01</span>
                            <span class="text-[#b6c0e7] font-medium">15 mins</span>
                        </div>
                    </div>

                    <div class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#903dff]/20 text-[#aebaff] border border-[#889eff]/30 mb-4">Intermediate</span>
                            <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">Reading a Candlestick Chart</h3>
                            <p class="text-xs text-[#b6c0e7] leading-relaxed">Understand price action patterns, bullish engulfing lines, and trends.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#889eff]/20 flex items-center justify-between text-xs font-semibold text-[#6d80ff]">
                            <span>Module 04</span>
                            <span class="text-[#b6c0e7] font-medium">25 mins</span>
                        </div>
                    </div>

                    <div class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#903dff]/20 text-[#aebaff] border border-[#889eff]/30 mb-4">Intermediate</span>
                            <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">How the KSE-100 Works</h3>
                            <p class="text-xs text-[#b6c0e7] leading-relaxed">A comprehensive breakdown of Pakistan stock exchange index weighting.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#889eff]/20 flex items-center justify-between text-xs font-semibold text-[#6d80ff]">
                            <span>Module 07</span>
                            <span class="text-[#b6c0e7] font-medium">20 mins</span>
                        </div>
                    </div>

                    <div class="tilt-card snap-center shrink-0 w-[82vw] max-w-xs sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#4e5bff]/30 text-[#aebaff] border border-[#889eff]/30 mb-4">Advanced</span>
                            <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">Building Your First Watchlist</h3>
                            <p class="text-xs text-[#b6c0e7] leading-relaxed">Filter companies using cash flow, debt ratios, and growth metrics.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#889eff]/20 flex items-center justify-between text-xs font-semibold text-[#6d80ff]">
                            <span>Module 12</span>
                            <span class="text-[#b6c0e7] font-medium">30 mins</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- =====================================================
             SECTION 6 — STATS STRIP (LIGHT MODE HIGH-CONTRAST)
             ===================================================== -->
        <section id="stats-section" class="py-20 relative overflow-hidden bg-white border-y border-slate-200/90 shadow-sm">
            <div class="absolute inset-0 pointer-events-none opacity-10" aria-hidden="true" style="background-image: radial-gradient(circle at 50% 50%, rgba(78,91,255,0.2), transparent 70%);"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums" data-target="10000" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Active Learners</p>
                    </div>
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums" data-target="50" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Courses</p>
                    </div>
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#0F172A] mb-2 tabular-nums" data-target="180" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#64748B] uppercase">Live Sessions</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- =====================================================
             SECTION 7 — PRICING
             ===================================================== -->
        <section id="pricing" class="py-24 bg-[#07113d] relative font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        Start Free. <em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">Upgrade When You're Ready.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#b6c0e7]">
                        Transparent membership plans tailored for retail investors.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-center">
                    <!-- Free Member Card -->
                    <div class="reveal-item bg-[#091449]/50 rounded-3xl p-8 border border-[#889eff]/20 backdrop-blur-xl shadow-xl hover:border-[#6d80ff]/50 transition-all duration-300 flex flex-col h-full">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-[#f7f8ff] mb-2">Free Member</h3>
                            <p class="text-sm text-[#b6c0e7] mb-6">Perfect for beginners taking their first steps.</p>
                            <div class="text-4xl font-extrabold text-[#f7f8ff] mb-8">
                                Rs. 0 <span class="text-sm font-normal text-[#b6c0e7]">/ forever</span>
                            </div>
                            <ul class="space-y-4 text-sm text-[#b6c0e7] mb-8">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#6d80ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Access to Community Feed</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#6d80ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Free Introductory Courses</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#6d80ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Basic Market Discussions</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}" wire:navigate
                           class="w-full py-3.5 px-6 rounded-xl border border-[#889eff]/40 text-[#f7f8ff] hover:bg-[#4e5bff] hover:border-[#4e5bff] font-bold text-center transition-all duration-200 block">
                            Join Free
                        </a>
                    </div>

                    <!-- Paid Subscriber Card -->
                    <div class="reveal-item bg-[#091449]/80 rounded-3xl p-8 border-2 border-[#6d80ff] shadow-[0_0_50px_rgba(78,91,255,0.3)] backdrop-blur-xl flex flex-col relative h-full md:-translate-y-3">
                        <div class="absolute -top-4 right-8 bg-gradient-to-r from-[#4e5bff] to-[#903dff] text-white font-bold text-xs uppercase tracking-widest px-5 py-1.5 rounded-full shadow-lg">
                            Most Popular
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-[#f7f8ff] mb-2">Paid Subscriber</h3>
                            <p class="text-sm text-[#b6c0e7] mb-6">For committed investors seeking deep research.</p>
                            <div class="text-4xl font-extrabold text-[#f7f8ff] mb-8">
                                Rs. 1,500 <span class="text-sm font-normal text-[#b6c0e7]">/ month</span>
                            </div>
                            <ul class="space-y-4 text-sm text-[#b6c0e7] mb-8">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[#f7f8ff]"><strong>Everything in Free</strong></span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[#f7f8ff]">Premium Research Reports</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[#f7f8ff]">Live Q&amp;A Webinars &amp; Sessions</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[#f7f8ff]">Course Certificates</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 shrink-0 text-[#4e5bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[#f7f8ff]">Priority Community Support</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}" wire:navigate
                           class="fp-magnetic w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#4e5bff] to-[#903dff] text-white font-bold text-center hover:shadow-[0_0_30px_rgba(78,91,255,0.5)] hover:scale-[1.02] transition-all duration-200 block shadow-lg focus:outline-none focus:ring-2 focus:ring-[#4e5bff]">
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
            ['id' => 4, 'q' => 'What does FinPulse actually offer?', 'a' => 'A free community to ask questions and learn from other investors, structured courses on investing basics, plain-language market research, and live sessions where you can get your questions answered directly.'],
            ['id' => 5, 'q' => 'Is the learning practical, or just theory?', 'a' => 'Practical. Courses are built around real examples — things like actual stock ratios, real chart patterns, and how the Pakistan stock market actually works — not abstract theory.'],
            ['id' => 6, 'q' => 'Will I learn about mutual funds and other investments, not just stocks?', 'a' => 'Yes. Courses cover mutual funds and general portfolio concepts alongside stocks, so you\'re not limited to just one type of investment.'],
            ['id' => 7, 'q' => 'Will I learn about risk management and handling market ups and downs?', 'a' => 'Yes. Understanding risk and staying calm during market swings is a core part of the curriculum, not an afterthought.'],
            ['id' => 8, 'q' => 'Can I interact with other learners and ask questions?', 'a' => 'Yes. The community feed is built exactly for this — post questions, join discussions, and learn from other members, not just from the courses.'],
            ['id' => 9, 'q' => 'Do you offer one-on-one sessions?', 'a' => 'Yes, for paid subscribers. You can book a 1-on-1 session for market analysis or to get your specific questions answered directly.'],
            ['id' => 10, 'q' => 'Will I get a certificate when I finish a course?', 'a' => 'Yes. Every completed course gives you a certificate you can download and share.'],
            ['id' => 11, 'q' => 'Will I have access to instructors, or is it just pre-recorded content?', 'a' => 'Both. Courses include structured content, and paid subscribers also get live Q&A sessions where you can talk directly with instructors.'],
            ['id' => 12, 'q' => 'How current is the course content?', 'a' => 'Research summaries are published on a regular schedule and reflect what\'s actually happening in the market — this isn\'t static content that goes stale.'],
            ['id' => 13, 'q' => 'Is FinPulse affiliated with a brokerage?', 'a' => 'No, FinPulse is an independent financial education and research platform. We do not operate as a licensed brokerage or offer direct stock execution services.'],
            ['id' => 14, 'q' => 'Do I need prior investing experience to start?', 'a' => 'Not at all! Our beginner modules break down basic concepts, budgeting, and stock market terminology step by step.'],
            ['id' => 15, 'q' => 'Can I cancel my subscription anytime?', 'a' => 'Yes, you can cancel or pause your paid subscription anytime directly from your user dashboard with no cancellation fees.'],
        ];
        @endphp

        <section id="faq" class="py-24 relative overflow-hidden bg-[#F8F9FA] font-['DM_Sans',sans-serif]">
            <div class="absolute inset-0 pointer-events-none opacity-30 z-0" aria-hidden="true" style="background-image: linear-gradient(rgba(78,91,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(78,91,255,0.08) 1px, transparent 1px); background-size: 64px 64px;"></div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10"
                 x-data="{
                    activeId: null,
                    toggle(id) {
                        this.activeId = (this.activeId === id ? null : id);
                    }
                 }">

                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto mb-14 reveal-item">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-[0.18em] text-[#4e5bff] bg-[#4e5bff]/10 border border-[#4e5bff]/20 mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#4e5bff] animate-pulse"></span>
                        FAQ
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0F172A] tracking-tight">
                        Frequently Asked <em class="not-italic text-[#4e5bff]">Questions.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-4 text-base sm:text-lg text-[#475569]">
                        Everything you need to know about FinPulse.
                    </p>
                </div>

                <!-- FAQ Accordion -->
                <div class="space-y-3">
                    @foreach ($faqs as $faq)
                        <div
                            class="reveal-item rounded-2xl overflow-hidden border bg-white transition-all duration-300"
                            :class="activeId === {{ $faq['id'] }} ? 'border-[#4e5bff]/40 shadow-lg' : 'border-slate-200 hover:border-slate-300'"
                        >
                            <button
                                @click="toggle({{ $faq['id'] }})"
                                class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer group"
                                :aria-expanded="activeId === {{ $faq['id'] }} ? 'true' : 'false'"
                                aria-controls="faq-ans-{{ $faq['id'] }}"
                                id="faq-btn-{{ $faq['id'] }}"
                            >
                                <span class="text-sm sm:text-base font-semibold text-[#0F172A] leading-snug group-hover:text-[#4e5bff] transition-colors">
                                    {{ $faq['q'] }}
                                </span>

                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-all duration-300"
                                     :class="activeId === {{ $faq['id'] }} ? 'bg-[#4e5bff] text-white rotate-45 shadow-sm' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m7-7H5"/>
                                    </svg>
                                </div>
                            </button>

                            <div
                                id="faq-ans-{{ $faq['id'] }}"
                                role="region"
                                aria-labelledby="faq-btn-{{ $faq['id'] }}"
                                x-show="activeId === {{ $faq['id'] }}"
                                x-collapse
                                x-cloak
                                class="border-t border-slate-100"
                            >
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
             SECTION 9 — BOTTOM CTA BANNER (LIGHT THEME)
             ===================================================== -->
        <section class="py-24 relative overflow-hidden bg-white fp-cta-section border-t border-slate-200 font-['DM_Sans',sans-serif]">
            <!-- Subtle Radial Gradient & Pattern Overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-60" style="background: radial-gradient(circle at 50% 50%, rgba(78,91,255,0.06), transparent 70%);"></div>
            <div class="absolute inset-0 pointer-events-none opacity-30" aria-hidden="true" style="background-image: linear-gradient(rgba(100, 116, 139, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.08) 1px, transparent 1px); background-size: 64px 64px;"></div>

            <!-- Soft Heartbeat Line Background -->
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center" aria-hidden="true" style="opacity:0.06;">
                <svg class="w-full max-w-6xl" viewBox="0 0 1000 300" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                    <path d="M0 150H200L240 60L320 240L390 100L440 150H600L640 80L700 220L760 130L800 150H1000" stroke="#4e5bff" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="orb orb-1" style="top:-40px; right:-30px; background: radial-gradient(circle, rgba(78,91,255,0.12) 0%, transparent 70%);"></div>
            <div class="orb orb-2" style="bottom:-50px; left:-40px; background: radial-gradient(circle, rgba(144,61,255,0.1) 0%, transparent 70%);"></div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8 reveal-item">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-[0.18em] text-[#4e5bff] bg-[#4e5bff]/10 border border-[#4e5bff]/20">
                    <span class="w-2 h-2 rounded-full bg-[#4e5bff] animate-pulse"></span>
                    Get Started
                </span>

                <h2 class="text-3xl sm:text-5xl font-extrabold text-[#0F172A] tracking-tight leading-tight">
                    Your Investing Journey
                    <span class="relative inline-block">
                        <em class="not-italic text-[#4e5bff]">Starts Today.</em>
                        <span class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full" aria-hidden="true"></span>
                    </span>
                </h2>
                <p class="text-lg text-[#475569] max-w-xl mx-auto leading-relaxed">
                    Join thousands of retail investors mastering financial literacy and building wealth.
                </p>
                @if (Route::has('register'))
                    <div>
                        <a href="{{ route('register') }}" wire:navigate
                           class="fp-magnetic inline-block px-12 py-5 bg-gradient-to-r from-[#4e5bff] to-[#903dff] text-white font-bold text-lg rounded-xl shadow-[0_10px_35px_rgba(78,91,255,0.35)] hover:scale-105 hover:shadow-[0_15px_45px_rgba(78,91,255,0.5)] transition-all duration-200">
                            Join Free
                        </a>
                    </div>
                @endif
            </div>
        </section>


        <!-- =====================================================
             SECTION 10 — FOOTER (PREMIUM DARK DESIGN)
             ===================================================== -->
        <footer class="relative overflow-hidden font-['DM_Sans',sans-serif]" style="background: linear-gradient(180deg, #040d12 0%, #071a12 100%);">
            <!-- Subtle grid pattern overlay -->
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="opacity:0.04; background-image: linear-gradient(rgba(78,200,130,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(78,200,130,0.3) 1px, transparent 1px); background-size: 60px 60px;"></div>

            <!-- Main Footer Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 pt-16 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

                    <!-- Left Column: Logo + Description + Socials -->
                    <div class="md:col-span-4 space-y-6">
                        <!-- Logo -->
                        <a href="/" wire:navigate class="inline-flex items-center gap-3 group" aria-label="FinPulse Home">
                            <div class="h-10 w-10 rounded-xl border border-emerald-500/30 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200 bg-emerald-950/50 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605"/>
                                </svg>
                            </div>
                            <span class="font-bold text-xl text-white">Fin<span class="text-emerald-400">Pulse</span></span>
                        </a>

                        <!-- Description -->
                        <p class="text-sm text-[#8a9a8e] leading-relaxed max-w-xs">
                            FinPulse helps you invest smarter by transforming financial education into actionable, easy-to-follow insights.
                        </p>

                        <!-- Social Icons -->
                        <div class="flex items-center gap-4 pt-1">
                            <a href="#" aria-label="Twitter / X" class="text-[#8a9a8e] hover:text-white transition-colors duration-200">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="#" aria-label="GitHub" class="text-[#8a9a8e] hover:text-white transition-colors duration-200">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                            </a>
                            <a href="#" aria-label="LinkedIn" class="text-[#8a9a8e] hover:text-white transition-colors duration-200">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="#" aria-label="YouTube" class="text-[#8a9a8e] hover:text-white transition-colors duration-200">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            <a href="#" aria-label="Instagram" class="text-[#8a9a8e] hover:text-white transition-colors duration-200">
                                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Link Columns Container -->
                    <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-3 gap-10 lg:gap-16">
                        <!-- Column 1: Platform -->
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-5">Platform</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Community Feed</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Stock Research</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Learning Modules</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Market Watchlist</a></li>
                            </ul>
                        </div>

                        <!-- Column 2: Resources -->
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-5">Resources</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Blog</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Research Library</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Webinars</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Newsletters</a></li>
                            </ul>
                        </div>

                        <!-- Column 3: Company -->
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-5">Company</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">About Us</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Careers</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Privacy Policy</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Terms of Service</a></li>
                                <li><a href="#" class="text-sm text-[#8a9a8e] hover:text-emerald-400 transition-colors duration-200">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Divider + Copyright Bar -->
                <div class="mt-14 pt-7 border-t border-emerald-900/40 flex flex-col sm:flex-row items-center justify-between text-xs text-[#5a6a5e] gap-3">
                    <p>&copy; {{ date('Y') }} FinPulse Design</p>
                    <p>All rights reserved.</p>
                </div>
            </div>

            <!-- Large Watermark Brand Text -->
            <div class="relative z-0 overflow-hidden select-none pointer-events-none" aria-hidden="true" style="margin-top: -30px;">
                <div class="max-w-[100vw] overflow-hidden flex items-end justify-center" style="height: 120px;">
                    <span class="whitespace-nowrap text-[min(14vw,160px)] font-black tracking-tight leading-none" style="color: transparent; -webkit-text-stroke: 1.5px rgba(16,185,129,0.12); text-stroke: 1.5px rgba(16,185,129,0.12);">
                        FinPulse
                    </span>
                </div>
                <!-- Bottom gradient fade -->
                <div class="absolute bottom-0 left-0 right-0 h-12" style="background: linear-gradient(to top, #071a12, transparent);"></div>
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
                    return () => {};
                });

                mm.add('(max-width: 767px)', () => {
                    // Mobile-only: simplified hero (no pin, no magnetic)
                    if (heroSection) {
                        ScrollTrigger.getAll().forEach(st => {
                            if (st.trigger === heroSection) st.kill();
                        });
                    }
                    return () => {};
                });

                mm.add('(prefers-reduced-motion: reduce)', () => {
                    // Kill all animations for reduced motion
                    gsap.globalTimeline.clear();
                    ScrollTrigger.getAll().forEach(st => st.kill());
                    return () => {};
                });

            }); // end gsap.context

        });
        </script>
    </body>
</html>