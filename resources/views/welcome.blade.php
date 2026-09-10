<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
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
            activeFaq: null,
            activeMockup: 0,
        }"
        @scroll.window="scrolled = (window.pageYOffset > 80)"
        class="font-sans antialiased text-[#b6c0e7] bg-[#050c2c] min-h-screen flex flex-col justify-between selection:bg-[#4e5bff] selection:text-white relative overflow-x-hidden"
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
             SECTION 2 — ABOUT FINPULSE (HERO SECTION THEME MATCHED)
             ===================================================== -->
        <section id="about" class="py-24 relative overflow-hidden bg-[#07113d] text-[#f7f8ff] font-['DM_Sans',sans-serif] fp-parallax-section">
            <!-- Hero Wash Overlay & Perspective Grid Overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-40 z-0" aria-hidden="true" style="background: linear-gradient(180deg, rgba(7, 17, 61, 0.95) 0%, rgba(8, 29, 105, 0.6) 50%, rgba(7, 17, 61, 0.98) 100%);"></div>
            <div class="absolute inset-0 pointer-events-none opacity-20 z-0" aria-hidden="true" style="background-image: linear-gradient(rgba(150, 177, 255, .2) 1px, transparent 1px), linear-gradient(90deg, rgba(150, 177, 255, .2) 1px, transparent 1px); background-size: 92px 92px;"></div>

            <!-- Glowing Ambient Orbs (Matching Hero's Blue/Violet Glows) -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-gradient-to-r from-[#4e5bff]/20 to-[#903dff]/20 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Centered Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-14 reveal-item">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-[0.18em] text-[#aebaff] bg-[#091449]/60 border border-[#889eff]/30 backdrop-blur-md mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#4e5bff] animate-pulse"></span>
                        Platform Showcase
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#f7f8ff] tracking-tight leading-tight">
                        See FinPulse in <em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">Action</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base sm:text-lg text-[#b6c0e7] max-w-2xl mx-auto leading-relaxed">
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
                        class="transition-all duration-300 ease-out transform rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(78,91,255,0.25)] border border-[#889eff]/30 bg-[#091449]/70 backdrop-blur-xl"
                        :style="`transform: perspective(1000px) rotateX(${(1 - scrollProgress) * 10}deg) scale(${0.92 + (scrollProgress * 0.08)}); opacity: ${Math.min(scrollProgress * 1.4, 1)};`"
                    >
                        <!-- Browser Header Window Bar -->
                        <div class="px-5 py-3.5 bg-[#030a30] border-b border-[#889eff]/20 flex items-center justify-between gap-4">
                            <!-- Left: Window Control Buttons -->
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                            </div>

                            <!-- Center: URL Pill Address Bar -->
                            <div class="flex-1 max-w-sm mx-auto bg-[#07113d]/80 border border-[#889eff]/20 rounded-lg px-3 py-1 text-xs text-[#b6c0e7] flex items-center justify-center gap-2 font-mono">
                                <svg class="w-3.5 h-3.5 text-[#6d80ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>finpulse.pk / platform-demo</span>
                            </div>

                            <!-- Right: Window Label -->
                            <div class="hidden sm:flex items-center gap-2 text-xs text-[#aebaff]/50 font-semibold uppercase tracking-wider">
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
                    <div class="p-6 rounded-2xl bg-[#091449]/50 border border-[#889eff]/20 backdrop-blur-md text-center hover:border-[#6d80ff]/50 transition-all duration-300">
                        <div class="text-3xl mb-3">🎓</div>
                        <h3 class="font-bold text-[#f7f8ff] text-base mb-1">Structured Courses</h3>
                        <p class="text-xs text-[#b6c0e7]">Step-by-step financial modules built for all experience levels.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-[#091449]/50 border border-[#889eff]/20 backdrop-blur-md text-center hover:border-[#6d80ff]/50 transition-all duration-300">
                        <div class="text-3xl mb-3">👥</div>
                        <h3 class="font-bold text-[#f7f8ff] text-base mb-1">Active Community</h3>
                        <p class="text-xs text-[#b6c0e7]">Real-time market discussions, discussions, and investor networking.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-[#091449]/50 border border-[#889eff]/20 backdrop-blur-md text-center hover:border-[#6d80ff]/50 transition-all duration-300">
                        <div class="text-3xl mb-3">📈</div>
                        <h3 class="font-bold text-[#f7f8ff] text-base mb-1">Actionable Insights</h3>
                        <p class="text-xs text-[#b6c0e7]">Data-driven research and fundamental metrics for real results.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             SECTION 3 — HOW IT WORKS
             ===================================================== -->
        <section id="how-it-works" class="py-24 relative overflow-hidden bg-[#07113d] font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        Three Steps. One Goal: <br class="sm:hidden"/><em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">A Smarter Investor.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#b6c0e7] max-w-xl mx-auto">
                        A structured path designed to take you from market beginner to confident investor.
                    </p>
                </div>

                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Desktop connecting line -->
                    <div class="hidden md:block absolute top-[72px] left-[calc(16.67%+32px)] right-[calc(16.67%+32px)] h-0.5 bg-[#889eff]/20 z-0" aria-hidden="true">
                        <div id="step-progress-line" class="h-full bg-gradient-to-r from-[#4e5bff] to-[#903dff] transition-all duration-1000 ease-out" style="width:0%"></div>
                    </div>

                    <!-- Step 01 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300" style="--stagger:1;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)]">
                            <span class="text-white text-2xl font-black">1</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 01</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Join the Community</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed">
                            Ask questions, follow market discussions, and learn from others — completely free.
                        </p>
                    </div>

                    <!-- Step 02 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300" style="--stagger:2;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)]">
                            <span class="text-white text-2xl font-black">2</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 02</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Learn with Structure</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed">
                            Work through courses built for beginners to advanced investors, at your own pace.
                        </p>
                    </div>

                    <!-- Step 03 -->
                    <div class="reveal-item rounded-2xl p-8 relative z-10 flex flex-col items-center text-center shadow-xl bg-[#091449]/60 border border-[#889eff]/20 backdrop-blur-xl hover:border-[#6d80ff]/60 transition-all duration-300" style="--stagger:3;">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)]">
                            <span class="text-white text-2xl font-black">3</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#6d80ff] mb-2">Step 03</span>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-3">Grow with Confidence</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed">
                            Unlock premium research, live sessions, and a guided path to your first investment.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- =====================================================
             SECTION 4 — FEATURES (Bento Grid)
             ===================================================== -->
        <section id="features" class="py-24 bg-[#050c2c] relative font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        Everything You Need, <em class="not-italic text-[#6d80ff] [text-shadow:0_0_28px_rgba(77,91,255,0.35)]">In One Place.</em>
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#b6c0e7]">
                        Tools and resources tailored specifically for retail financial education.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Large Tile: Community Feed -->
                    <div class="reveal-item group relative bg-[#091449]/50 rounded-2xl p-8 border border-[#889eff]/20 backdrop-blur-xl shadow-xl overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#6d80ff]/60 md:hover:shadow-[0_0_35px_rgba(78,91,255,0.2)]
                                sm:col-span-2 lg:col-span-2 lg:row-span-2">
                        <div class="absolute top-6 right-6 flex gap-1.5" aria-hidden="true">
                            <div class="w-7 h-7 rounded-full bg-[#4e5bff]/30 border border-[#6d80ff]/40 animate-badge-pulse" style="animation-delay:0s;"></div>
                            <div class="w-7 h-7 rounded-full bg-[#903dff]/30 border border-[#903dff]/40 animate-badge-pulse" style="animation-delay:0.4s;"></div>
                            <div class="w-7 h-7 rounded-full bg-[#4e5bff]/20 border border-[#6d80ff]/30 animate-badge-pulse" style="animation-delay:0.8s;"></div>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(78,91,255,0.4)] group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#f7f8ff] mb-2">Community Feed</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed max-w-xs">Real conversations with real investors.</p>
                        <div class="mt-8 space-y-3" aria-hidden="true">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#4e5bff]/40 shrink-0"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-2 bg-[#889eff]/20 rounded-full w-3/4"></div>
                                    <div class="h-1.5 bg-[#889eff]/10 rounded-full w-1/2"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#6d80ff]/30 shrink-0"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-2 bg-[#889eff]/20 rounded-full w-full"></div>
                                    <div class="h-1.5 bg-[#889eff]/10 rounded-full w-2/3"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#903dff]/30 shrink-0"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-2 bg-[#889eff]/20 rounded-full w-4/5"></div>
                                    <div class="h-1.5 bg-[#889eff]/10 rounded-full w-3/5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tile: Courses & Certificates -->
                    <div class="reveal-item group relative bg-[#091449]/50 rounded-2xl p-7 border border-[#889eff]/20 backdrop-blur-xl shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#6d80ff]/60 md:hover:shadow-[0_0_30px_rgba(78,91,255,0.2)]">
                        <div class="absolute top-5 right-5" aria-hidden="true">
                            <svg class="w-12 h-12 opacity-30 group-hover:opacity-60 transition-opacity duration-200" viewBox="0 0 36 36" fill="none">
                                <circle cx="18" cy="18" r="15.9" stroke="#6d80ff" stroke-width="3" stroke-dasharray="75 25" stroke-dashoffset="25" transform="rotate(-90 18 18)"/>
                            </svg>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">Courses &amp; Certificates</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed">Structured learning you can show off.</p>
                    </div>

                    <!-- Tile: Live Sessions -->
                    <div class="reveal-item group relative bg-[#091449]/50 rounded-2xl p-7 border border-[#889eff]/20 backdrop-blur-xl shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#6d80ff]/60 md:hover:shadow-[0_0_30px_rgba(78,91,255,0.2)]">
                        <div class="absolute top-5 right-5 flex items-center gap-1.5" aria-hidden="true">
                            <span class="live-dot w-2.5 h-2.5 rounded-full bg-[#4e5bff] block animate-pulse"></span>
                            <span class="text-xs font-bold text-[#6d80ff] uppercase tracking-wider">Live</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">Live Sessions</h3>
                        <p class="text-sm text-[#b6c0e7] leading-relaxed">Get your questions answered, live.</p>
                    </div>

                    <!-- Tile: Premium Research -->
                    <div class="reveal-item group lock-shimmer relative bg-[#091449]/50 rounded-2xl p-7 border border-[#889eff]/20 backdrop-blur-xl shadow-md overflow-hidden
                                transition-all duration-300 md:hover:-translate-y-1 md:hover:border-[#6d80ff]/60 md:hover:shadow-[0_0_30px_rgba(78,91,255,0.2)]
                                sm:col-span-2 lg:col-span-3">
                        <div class="absolute top-5 right-6" aria-hidden="true">
                            <svg class="w-8 h-8 text-[#6d80ff]/40 group-hover:text-[#6d80ff]/80 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center mb-0 shadow-[0_0_15px_rgba(78,91,255,0.3)] shrink-0 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-[#f7f8ff] mb-2">Premium Research</h3>
                                <p class="text-sm text-[#b6c0e7] leading-relaxed">Insights the free internet won't give you.</p>
                            </div>
                        </div>
                    </div>
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
                    <div class="tilt-card snap-center shrink-0 w-72 sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
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

                    <div class="tilt-card snap-center shrink-0 w-72 sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
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

                    <div class="tilt-card snap-center shrink-0 w-72 sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
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

                    <div class="tilt-card snap-center shrink-0 w-72 sm:w-auto bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-200 flex flex-col justify-between">
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
             SECTION 6 — STATS STRIP
             ===================================================== -->
        <section id="stats-section" class="py-20 relative overflow-hidden bg-[#050c2c] border-y border-[#889eff]/20">
            <div class="absolute inset-0 pointer-events-none opacity-20" aria-hidden="true" style="background-image: radial-gradient(circle at 50% 50%, rgba(78,91,255,0.3), transparent 70%);"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#f7f8ff] mb-2 tabular-nums [text-shadow:0_0_25px_rgba(78,91,255,0.5)]" data-target="10000" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#aebaff] uppercase">Active Learners</p>
                    </div>
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#f7f8ff] mb-2 tabular-nums [text-shadow:0_0_25px_rgba(78,91,255,0.5)]" data-target="50" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#aebaff] uppercase">Courses</p>
                    </div>
                    <div class="min-h-[100px] flex flex-col justify-center">
                        <div class="text-4xl sm:text-5xl font-extrabold text-[#f7f8ff] mb-2 tabular-nums [text-shadow:0_0_25px_rgba(78,91,255,0.5)]" data-target="180" data-suffix="+">
                            <span class="stat-number">0</span>
                        </div>
                        <div class="w-12 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mb-3 stat-underline" aria-hidden="true"></div>
                        <p class="text-xs font-bold tracking-widest text-[#aebaff] uppercase">Live Sessions</p>
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
             SECTION 8 — FAQ ACCORDION
             ===================================================== -->
        <section id="faq" class="py-24 relative overflow-hidden bg-[#050c2c] font-['DM_Sans',sans-serif]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16 reveal-item">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#f7f8ff] tracking-tight">
                        Common Questions.
                    </h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full mx-auto mt-4"></div>
                    <p class="mt-5 text-base text-[#b6c0e7]">
                        Got questions? We've got answers.
                    </p>
                </div>

                <div class="space-y-4" x-data="{ activeFaq: null }">
                    <div class="reveal-item rounded-2xl overflow-hidden border border-[#889eff]/20 bg-[#091449]/50 backdrop-blur-xl shadow-md transition-all duration-200"
                         :class="activeFaq === 1 ? 'border-[#6d80ff]/60 bg-[#091449]/80 shadow-[0_0_25px_rgba(78,91,255,0.2)]' : ''">
                        <button @click="activeFaq = (activeFaq === 1 ? null : 1)"
                                class="w-full px-6 py-5 text-left font-bold text-base text-[#f7f8ff] flex items-center justify-between focus:outline-none gap-4"
                                :aria-expanded="activeFaq === 1 ? 'true' : 'false'"
                                aria-controls="faq-1-answer" id="faq-1-btn">
                            <span>Is FinPulse affiliated with a brokerage?</span>
                            <svg class="w-5 h-5 text-[#6d80ff] shrink-0 transition-transform duration-300"
                                 style="transition-timing-function: cubic-bezier(0.34,1.56,0.64,1);"
                                 :style="activeFaq === 1 ? 'transform: rotate(180deg)' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="faq-1-answer" role="region" aria-labelledby="faq-1-btn"
                             x-show="activeFaq === 1" x-collapse
                             class="px-6 pb-5 text-sm text-[#b6c0e7] leading-relaxed">
                            No, FinPulse is an independent financial education and research platform. We do not operate as a licensed brokerage or offer direct stock execution services.
                        </div>
                    </div>

                    <div class="reveal-item rounded-2xl overflow-hidden border border-[#889eff]/20 bg-[#091449]/50 backdrop-blur-xl shadow-md transition-all duration-200"
                         :class="activeFaq === 2 ? 'border-[#6d80ff]/60 bg-[#091449]/80 shadow-[0_0_25px_rgba(78,91,255,0.2)]' : ''">
                        <button @click="activeFaq = (activeFaq === 2 ? null : 2)"
                                class="w-full px-6 py-5 text-left font-bold text-base text-[#f7f8ff] flex items-center justify-between focus:outline-none gap-4"
                                :aria-expanded="activeFaq === 2 ? 'true' : 'false'"
                                aria-controls="faq-2-answer" id="faq-2-btn">
                            <span>Do I need prior investing experience to start?</span>
                            <svg class="w-5 h-5 text-[#6d80ff] shrink-0 transition-transform duration-300"
                                 style="transition-timing-function: cubic-bezier(0.34,1.56,0.64,1);"
                                 :style="activeFaq === 2 ? 'transform: rotate(180deg)' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="faq-2-answer" role="region" aria-labelledby="faq-2-btn"
                             x-show="activeFaq === 2" x-collapse
                             class="px-6 pb-5 text-sm text-[#b6c0e7] leading-relaxed">
                            Not at all! Our beginner modules break down basic concepts, budgeting, and stock market terminology step by step.
                        </div>
                    </div>

                    <div class="reveal-item rounded-2xl overflow-hidden border border-[#889eff]/20 bg-[#091449]/50 backdrop-blur-xl shadow-md transition-all duration-200"
                         :class="activeFaq === 3 ? 'border-[#6d80ff]/60 bg-[#091449]/80 shadow-[0_0_25px_rgba(78,91,255,0.2)]' : ''">
                        <button @click="activeFaq = (activeFaq === 3 ? null : 3)"
                                class="w-full px-6 py-5 text-left font-bold text-base text-[#f7f8ff] flex items-center justify-between focus:outline-none gap-4"
                                :aria-expanded="activeFaq === 3 ? 'true' : 'false'"
                                aria-controls="faq-3-answer" id="faq-3-btn">
                            <span>Can I cancel my subscription anytime?</span>
                            <svg class="w-5 h-5 text-[#6d80ff] shrink-0 transition-transform duration-300"
                                 style="transition-timing-function: cubic-bezier(0.34,1.56,0.64,1);"
                                 :style="activeFaq === 3 ? 'transform: rotate(180deg)' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="faq-3-answer" role="region" aria-labelledby="faq-3-btn"
                             x-show="activeFaq === 3" x-collapse
                             class="px-6 pb-5 text-sm text-[#b6c0e7] leading-relaxed">
                            Yes, you can cancel or pause your paid subscription anytime directly from your user dashboard with no cancellation fees.
                        </div>
                    </div>

                    <div class="reveal-item rounded-2xl overflow-hidden border border-[#889eff]/20 bg-[#091449]/50 backdrop-blur-xl shadow-md transition-all duration-200"
                         :class="activeFaq === 4 ? 'border-[#6d80ff]/60 bg-[#091449]/80 shadow-[0_0_25px_rgba(78,91,255,0.2)]' : ''">
                        <button @click="activeFaq = (activeFaq === 4 ? null : 4)"
                                class="w-full px-6 py-5 text-left font-bold text-base text-[#f7f8ff] flex items-center justify-between focus:outline-none gap-4"
                                :aria-expanded="activeFaq === 4 ? 'true' : 'false'"
                                aria-controls="faq-4-answer" id="faq-4-btn">
                            <span>Are live sessions recorded if I miss one?</span>
                            <svg class="w-5 h-5 text-[#6d80ff] shrink-0 transition-transform duration-300"
                                 style="transition-timing-function: cubic-bezier(0.34,1.56,0.64,1);"
                                 :style="activeFaq === 4 ? 'transform: rotate(180deg)' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="faq-4-answer" role="region" aria-labelledby="faq-4-btn"
                             x-show="activeFaq === 4" x-collapse
                             class="px-6 pb-5 text-sm text-[#b6c0e7] leading-relaxed">
                            Yes, all live webinars and research Q&amp;A sessions are recorded and archived for paid subscribers to watch on demand.
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- =====================================================
             SECTION 9 — BOTTOM CTA BANNER
             ===================================================== -->
        <section class="py-24 relative overflow-hidden bg-[#07113d] fp-cta-section border-t border-[#889eff]/20 font-['DM_Sans',sans-serif]">
            <div class="absolute inset-0 pointer-events-none opacity-30" style="background: radial-gradient(circle at 50% 50%, rgba(78,91,255,0.25), transparent 70%);"></div>
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center" aria-hidden="true" style="opacity:0.04;">
                <svg class="w-full max-w-6xl" viewBox="0 0 1000 300" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                    <path d="M0 150H200L240 60L320 240L390 100L440 150H600L640 80L700 220L760 130L800 150H1000" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="orb orb-1" style="top:-40px; right:-30px; background: radial-gradient(circle, rgba(78,91,255,0.25) 0%, transparent 70%);"></div>
            <div class="orb orb-2" style="bottom:-50px; left:-40px; background: radial-gradient(circle, rgba(144,61,255,0.2) 0%, transparent 70%);"></div>

            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
                <h2 class="text-3xl sm:text-5xl font-extrabold text-[#f7f8ff] tracking-tight leading-tight">
                    Your Investing Journey
                    <span class="relative inline-block">
                        Starts Today.
                        <span class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-[#4e5bff] to-[#903dff] rounded-full" aria-hidden="true"></span>
                    </span>
                </h2>
                <p class="text-lg text-[#b6c0e7] max-w-xl mx-auto leading-relaxed">
                    Join thousands of retail investors mastering financial literacy and building wealth.
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" wire:navigate
                       class="fp-magnetic inline-block px-12 py-5 bg-gradient-to-r from-[#4e5bff] to-[#903dff] text-white font-bold text-lg rounded-xl shadow-[0_0_35px_rgba(78,91,255,0.4)] hover:scale-105 hover:shadow-[0_0_50px_rgba(78,91,255,0.6)] transition-all duration-200">
                        Join Free
                    </a>
                @endif
            </div>
        </section>


        <!-- =====================================================
             SECTION 10 — FOOTER
             ===================================================== -->
        <footer class="bg-[#030822] border-t border-[#889eff]/20 text-[#f7f8ff] py-16 font-['DM_Sans',sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="space-y-4 md:col-span-1">
                        <a href="/" wire:navigate class="inline-flex items-center gap-3 group" aria-label="FinPulse Home">
                            <div class="h-10 w-10 rounded-full border border-[#889eff]/30 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200 bg-[#07113d] shadow-[0_0_15px_rgba(78,91,255,0.3)]">
                                <span class="text-white font-black text-lg">FP</span>
                            </div>
                            <span class="font-bold text-xl text-white">Fin<span class="text-[#6d80ff]">Pulse</span></span>
                        </a>
                        <p class="text-xs uppercase tracking-widest text-[#6d80ff] font-bold">Learn. Track. Invest.</p>
                        <p class="text-xs text-[#b6c0e7] leading-relaxed">Empowering retail investors with financial literacy, research, and tools.</p>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-[#6d80ff]">Company</h4>
                        <ul class="space-y-2 text-sm text-[#b6c0e7]">
                            <li><a href="#" class="hover:text-white transition-colors duration-150">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Terms of Service</a></li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-[#6d80ff]">Resources</h4>
                        <ul class="space-y-2 text-sm text-[#b6c0e7]">
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Research Library</a></li>
                            <li><a href="#" class="hover:text-white transition-colors duration-150">Community Guidelines</a></li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-[#6d80ff]">Stay Informed</h4>
                        <p class="text-xs text-[#b6c0e7]">Subscribe to our weekly financial insights newsletter.</p>
                        <form onsubmit="event.preventDefault();" class="flex gap-2 max-w-md" aria-label="Newsletter subscription form">
                            <label for="newsletter-email" class="sr-only">Email address</label>
                            <input id="newsletter-email" type="email" placeholder="Enter your email" autocomplete="email"
                                   class="bg-[#091449]/70 border border-[#889eff]/30 rounded-lg px-4 py-2.5 text-sm text-white placeholder-[#b6c0e7]/50 flex-1 focus:outline-none focus:border-[#6d80ff] focus:ring-1 focus:ring-[#6d80ff] transition-all duration-200">
                            <button type="submit"
                                    class="bg-gradient-to-r from-[#4e5bff] to-[#903dff] text-white font-bold text-sm px-5 py-2.5 rounded-lg hover:shadow-[0_0_20px_rgba(78,91,255,0.4)] hover:scale-[1.02] transition-all duration-200 shrink-0 focus:outline-none focus:ring-2 focus:ring-[#6d80ff]">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>

                <div class="pt-8 border-t border-[#889eff]/20 flex flex-col sm:flex-row items-center justify-between text-xs text-[#b6c0e7]/60 gap-4">
                    <p>© {{ date('Y') }} FinPulse. All rights reserved.</p>
                    <div class="flex gap-5 items-center">
                        <a href="#" aria-label="Twitter" class="text-[#b6c0e7]/60 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="#" aria-label="LinkedIn" class="text-[#b6c0e7]/60 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="#" aria-label="YouTube" class="text-[#b6c0e7]/60 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
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

                    // Pin hero section on scroll with parallax out
                    ScrollTrigger.create({
                        trigger: heroSection,
                        start: 'top top',
                        end: '+=100%',
                        pin: true,
                        pinSpacing: false,
                    });

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
                        { opacity: 0, y: 30 },
                        {
                            opacity: 1, y: 0,
                            duration: 0.8,
                            ease: 'power2.out',
                            scrollTrigger: {
                                trigger: footer,
                                start: 'top 90%',
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