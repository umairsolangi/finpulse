<x-app-layout>

<style>
    .dash-font { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Mesh gradient background ── */
    .dash-bg {
        background-color: #f0fdf4;
        background-image:
            radial-gradient(ellipse 80% 60% at 10% -10%, rgba(57,229,84,0.12) 0%, transparent 55%),
            radial-gradient(ellipse 60% 50% at 90% 100%, rgba(40,160,74,0.08) 0%, transparent 55%),
            radial-gradient(ellipse 50% 40% at 60% 40%, rgba(57,229,84,0.05) 0%, transparent 50%);
    }

    /* ── Welcome card gradient ── */
    .welcome-card {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #dcfce7 100%);
        border: 1px solid rgba(57,229,84,0.2);
        box-shadow: 0 4px 6px -1px rgba(57,229,84,0.06), 0 20px 50px -10px rgba(57,229,84,0.12), 0 0 0 1px rgba(255,255,255,0.8) inset;
    }

    /* ── Stat card base ── */
    .stat-card {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04);
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #39E554, #28a04a);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(57,229,84,0.15), 0 4px 10px rgba(0,0,0,0.06);
        border-color: rgba(57,229,84,0.35);
    }
    .stat-card:hover::before { opacity: 1; }

    /* ── Action card ── */
    .action-card {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04);
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(57,229,84,0.18), 0 4px 12px rgba(0,0,0,0.06);
        border-color: rgba(57,229,84,0.4);
    }

    /* ── Upgrade card ── */
    .upgrade-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 60%, #bbf7d0 100%);
        border: 1px solid rgba(57,229,84,0.3);
        box-shadow: 0 4px 20px rgba(57,229,84,0.15);
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
    }
    .upgrade-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 45px rgba(57,229,84,0.25);
    }

    /* ── Green icon container ── */
    .icon-wrap {
        background: linear-gradient(135deg, rgba(57,229,84,0.15), rgba(40,160,74,0.1));
        border: 1px solid rgba(57,229,84,0.2);
        transition: transform 0.3s ease, background 0.3s ease;
    }
    .action-card:hover .icon-wrap,
    .stat-card:hover .icon-wrap { 
        transform: scale(1.12) rotate(-3deg);
        background: linear-gradient(135deg, rgba(57,229,84,0.25), rgba(40,160,74,0.18));
    }

    /* ── Pulse ring on live indicator ── */
    @keyframes liveRing {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(2.4); opacity: 0; }
    }
    .live-ring::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #39E554;
        animation: liveRing 1.8s ease-out infinite;
    }

    /* ── Number counter shimmer ── */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-num { animation: countUp 0.6s ease both; }

    /* ── Stagger delays ── */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* ── Section label pill ── */
    .section-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #28a04a;
    }
</style>

<div class="dash-bg min-h-screen dash-font">
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-7">

        {{-- ══════════════════════════════════════
             WELCOME BANNER
        ══════════════════════════════════════ --}}
        <div class="welcome-card rounded-3xl p-7 sm:p-10 relative overflow-hidden fp-animate-in">

            {{-- Decorative blobs --}}
            <div class="absolute -top-12 -right-12 w-56 h-56 rounded-full bg-[#39E554]/12 blur-3xl pointer-events-none fp-parallax-blob-1"></div>
            <div class="absolute -bottom-8 -left-8 w-40 h-40 rounded-full bg-[#28a04a]/10 blur-2xl pointer-events-none fp-parallax-blob-2"></div>
            <div class="absolute top-1/2 right-32 w-24 h-24 rounded-full bg-[#39E554]/8 blur-xl pointer-events-none"></div>

            {{-- Decorative grid dots --}}
            <div class="absolute inset-0 opacity-[0.025]" style="background-image: radial-gradient(circle, #28a04a 1px, transparent 1px); background-size: 24px 24px;" aria-hidden="true"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    {{-- Live badge --}}
                    <div class="inline-flex items-center gap-2 mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="live-ring absolute inline-flex h-full w-full rounded-full bg-[#39E554] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#39E554]"></span>
                        </span>
                        <span class="section-label text-[#28a04a]">Live Dashboard</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Welcome back,<br>
                        <span class="relative inline-block">
                            <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">{{ auth()->user()->name }}</span>
                            <span class="ml-2">👋</span>
                        </span>
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base max-w-md leading-relaxed font-medium">
                        Continue your financial learning journey. Your next milestone is just one lesson away.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0">
                    <a href="{{ route('learn.index') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-2xl font-bold text-sm text-slate-950 shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl"
                        style="background:linear-gradient(135deg,#39E554,#32d44b); box-shadow:0 8px 25px rgba(57,229,84,0.35);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Start Learning
                    </a>
                    <a href="{{ route('feed') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-2xl font-bold text-sm text-slate-700 bg-white/70 border border-slate-200 hover:border-[#39E554]/40 hover:text-[#28a04a] hover:bg-white transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Community
                    </a>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             QUICK STATS
        ══════════════════════════════════════ --}}
        <div>
            <p class="section-label mb-4 px-1">Your Progress</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 fp-stagger-grid">

                {{-- Courses --}}
                <div class="stat-card fp-tilt-card rounded-2xl p-5 stat-num delay-1">
                    <div class="icon-wrap w-11 h-11 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">0</div>
                    <div class="text-xs font-semibold text-slate-500">Courses In Progress</div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full w-0 rounded-full" style="background:linear-gradient(90deg,#39E554,#28a04a);"></div>
                    </div>
                </div>

                {{-- Certificates --}}
                <div class="stat-card fp-tilt-card rounded-2xl p-5 stat-num delay-2">
                    <div class="icon-wrap w-11 h-11 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">0</div>
                    <div class="text-xs font-semibold text-slate-500">Certificates Earned</div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full w-0 rounded-full" style="background:linear-gradient(90deg,#39E554,#28a04a);"></div>
                    </div>
                </div>

                {{-- Posts --}}
                <div class="stat-card fp-tilt-card rounded-2xl p-5 stat-num delay-3">
                    <div class="icon-wrap w-11 h-11 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">0</div>
                    <div class="text-xs font-semibold text-slate-500">Community Posts</div>
                    <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full w-0 rounded-full" style="background:linear-gradient(90deg,#39E554,#28a04a);"></div>
                    </div>
                </div>

                {{-- Plan --}}
                <div class="stat-card fp-tilt-card rounded-2xl p-5 stat-num delay-4">
                    <div class="icon-wrap w-11 h-11 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;">Free</div>
                    <div class="text-xs font-semibold text-slate-500">Current Plan</div>
                    <div class="mt-3">
                        <a href="{{ route('pricing') }}" wire:navigate
                            class="text-[10px] font-bold uppercase tracking-wider text-[#28a04a] hover:text-[#39E554] transition-colors">
                            Upgrade →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             QUICK ACTIONS
        ══════════════════════════════════════ --}}
        <div>
            <p class="section-label mb-4 px-1">Quick Actions</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 fp-animate-in">

                {{-- Continue Learning --}}
                <a href="{{ route('learn.index') }}" wire:navigate class="action-card fp-tilt-card rounded-2xl p-6 block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="icon-wrap w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#39E554] group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-[#28a04a] transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Continue Learning
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Browse structured financial courses — from PSX basics to advanced equity analysis.</p>
                </a>

                {{-- Research Hub --}}
                <a href="{{ route('research.index') }}" wire:navigate class="action-card fp-tilt-card rounded-2xl p-6 block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="icon-wrap w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#39E554] group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-[#28a04a] transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Research Hub
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed">In-depth PSX sector reports, company valuations, and weekly market insights.</p>
                </a>

                {{-- Live Sessions --}}
                <a href="{{ route('live-sessions.index') }}" wire:navigate class="action-card fp-tilt-card rounded-2xl p-6 block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="icon-wrap w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#39E554] group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-[#28a04a] transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Live Sessions
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Join expert-led live webinars on stocks, mutual funds, and personal finance.</p>
                </a>

                {{-- Community Feed --}}
                <a href="{{ route('feed') }}" wire:navigate class="action-card fp-tilt-card rounded-2xl p-6 block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="icon-wrap w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#39E554] group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-[#28a04a] transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Community Feed
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Discuss market moves, share trade ideas, and learn from 30,000+ investors.</p>
                </a>

                {{-- Leaderboard --}}
                <a href="{{ route('leaderboard') }}" wire:navigate class="action-card fp-tilt-card rounded-2xl p-6 block group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="icon-wrap w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#39E554] group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 group-hover:text-[#28a04a] transition-colors" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Leaderboard
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed">See how you rank against top learners on FinPulse this month.</p>
                </a>

                {{-- Upgrade to Pro — full-width spanning card --}}
                <a href="{{ route('pricing') }}" wire:navigate class="upgrade-card fp-tilt-card rounded-2xl p-6 block group relative overflow-hidden">
                    {{-- Shimmer sweep --}}
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:linear-gradient(105deg,transparent 40%,rgba(57,229,84,0.15) 50%,transparent 60%); animation: none;"></div>

                    <div class="relative flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background:linear-gradient(135deg,#39E554,#28a04a); box-shadow:0 6px 20px rgba(57,229,84,0.4);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#28a04a] bg-white/60 border border-[#39E554]/30 px-2.5 py-1 rounded-full">
                            Recommended
                        </span>
                    </div>
                    <h3 class="text-base font-black text-slate-900 mb-1.5" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        Upgrade to Pro
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-3">Unlock live sessions, premium courses, and 1-on-1 expert mentorship.</p>
                    <span class="inline-flex items-center gap-1.5 text-sm font-bold text-[#28a04a] group-hover:gap-3 transition-all duration-300">
                        View Plans
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </a>

            </div>
        </div>

    </div>
</div>

</x-app-layout>