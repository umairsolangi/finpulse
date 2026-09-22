<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="{{ route('research.index') }}" wire:navigate
            class="inline-flex items-center gap-2 text-xs font-semibold text-gray-500 hover:text-[#0B1A33] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Research Catalog
        </a>
    </div>

    <article class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden">
        {{-- Report Top Header --}}
        <div class="p-8 sm:p-12 border-b border-gray-100 bg-gradient-to-b from-[#0B1A33]/[0.02] to-transparent">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider
                    {{ $isFree ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($isPaid ? 'bg-amber-50 text-[#39E554] border border-[#39E554]/30' : 'bg-blue-50 text-blue-700 border border-blue-200') }}">
                    {{ ucfirst($item->tier->value) }} Tier
                </span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Institutional Research Brief
                </span>
                <span class="text-xs text-gray-400">•</span>
                <span class="text-xs text-gray-500">{{ $item->duration_minutes ?? 5 }} min read</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-[#0B1A33] font-serif tracking-tight leading-tight">
                {{ $item->title }}
            </h1>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#0B1A33] text-[#39E554] flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($item->author->name ?? 'FP', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0B1A33]">{{ $item->author->name ?? 'FinPulse Analyst' }}</p>
                        <p class="text-xs text-gray-500">Published {{ $item->published_at?->format('F d, Y') ?? 'Recently' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium">Research ID #{{ $item->id }}</span>
                </div>
            </div>
        </div>

        {{-- Body / Gated Content --}}
        <div class="p-8 sm:p-12">
            {{-- Executive Summary Box --}}
            <div class="mb-8 p-6 bg-slate-50 rounded-2xl border-l-4 border-[#0B1A33]">
                <h2 class="text-xs font-bold text-[#0B1A33] uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Executive Summary & Takeaways
                </h2>
                <div class="text-sm text-gray-700 leading-relaxed">
                    {{ Str::limit(strip_tags($item->body), 260) }}
                </div>
            </div>

            @if($canAccess)
                <div class="prose prose-slate max-w-none text-gray-800 leading-relaxed space-y-4">
                    {!! nl2br(e($item->body)) !!}
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 text-xs text-gray-400 flex items-center justify-between">
                    <span>FinPulse Quantitative Research & Market Insights</span>
                    <span>For educational & informational purposes only.</span>
                </div>
            @else
                {{-- Teaser + Gated Prompt --}}
                <div class="relative mt-6">
                    <div class="select-none filter blur-sm opacity-40 text-gray-500 space-y-4 pointer-events-none">
                        <p>Detailed macroeconomic breakdowns and valuation sensitivities reveal cross-asset correlation shifts across equities, fixed-income yields, and sovereign balance sheets...</p>
                        <p>Our proprietary quantitative model applies discounted cash flow iterations across low, base, and high rate environments to estimate fundamental margin compression...</p>
                        <p>Key risk parameters include credit default spread expansion, currency volatility, and terminal multiple compression across primary sectors.</p>
                    </div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/70 backdrop-blur-[2px] p-6 text-center rounded-2xl border border-amber-200">
                        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#0B1A33]">
                            {{ $isPaid ? 'Premium Institutional Access Required' : 'Free Registration Required' }}
                        </h3>
                        <p class="text-xs text-gray-600 max-w-md mt-1 mb-5">
                            {{ $isPaid ? 'This institutional market summary includes proprietary valuation matrices reserved for Paid Subscribers.' : 'Sign in to your free FinPulse account to unlock this research summary.' }}
                        </p>

                        @guest
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-white bg-[#0B1A33] hover:bg-[#13274c] rounded-xl transition-all">
                                    Log In
                                </a>
                                <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-semibold text-[#0B1A33] bg-[#39E554] hover:bg-[#d4a942] rounded-xl transition-all">
                                    Create Free Account
                                </a>
                            </div>
                        @else
                            <a href="{{ route('pricing') }}" wire:navigate class="px-5 py-2.5 text-xs font-bold text-finpulse-navy bg-[#39E554] hover:bg-amber-400 rounded-xl transition-all shadow-sm">
                                Upgrade to Paid Subscriber
                            </a>
                        @endguest
                    </div>
            @endif

            {{-- Brokerage Partner Referral CTA Banner --}}
            @if($canAccess)
                <div class="mt-10 p-6 rounded-2xl bg-gradient-to-r from-[#0B1A33] to-[#12284d] text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md border border-gray-800">
                    <div class="space-y-1.5">
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-0.5 bg-[#39E554]/20 text-amber-300 rounded-full border border-[#39E554]/40">
                            Brokerage Partner Offer
                        </span>
                        <h4 class="font-bold text-base text-white">Ready to execute your investment thesis?</h4>
                        <p class="text-xs text-gray-300 max-w-lg">
                            Open a digital PSX trading account with our SECP-regulated partner brokerage and unlock reduced commission rates.
                        </p>
                    </div>
                    <a
                        href="{{ route('referral.brokerage') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="shrink-0 px-5 py-2.5 bg-[#39E554] hover:bg-amber-400 text-finpulse-navy font-bold text-xs rounded-xl shadow-sm transition-all hover:-translate-y-0.5 flex items-center gap-1.5"
                    >
                        <span>Open Trading Account</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </article>
</div>
