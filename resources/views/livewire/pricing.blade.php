<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-12" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .fp-pricing-free {
            background:#fff; border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
        }
        .fp-pricing-free:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,0.08); }
        .fp-pricing-pro {
            background:linear-gradient(160deg,#0a1628 0%,#0B1A33 55%,#0c1e3a 100%);
            border:2px solid rgba(57,229,84,0.4);
            box-shadow:0 8px 32px rgba(57,229,84,0.2), 0 2px 8px rgba(0,0,0,0.3);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
        }
        .fp-pricing-pro:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(57,229,84,0.3), 0 4px 16px rgba(0,0,0,0.3); }
        .fp-check-green { color:#39E554; }
        .section-label { font-size:0.65rem; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:#28a04a; }
    </style>

    {{-- Header --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto fp-animate-in">
        
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
            Invest in Your <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Financial Mastery</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-500 leading-relaxed font-medium">
            Choose the membership tier tailored to your financial journey. Upgrade anytime to unlock institutional-grade market research, certification masterclasses, and live webinars.
        </p>

        @if(session('info'))
            <div class="p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl text-sm font-medium">
                {{ session('info') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-xl text-sm font-medium">
                {{ session('warning') }}
            </div>
        @endif
    </div>

    {{-- Pricing Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch max-w-4xl mx-auto fp-stagger-grid">

        {{-- Free Card --}}
        <div class="fp-pricing-free rounded-2xl p-8 flex flex-col justify-between">
            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Free Member</h3>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Foundational literacy &amp; community engagement</p>
                </div>

                <div class="flex items-baseline gap-1 pb-6" style="border-bottom:1px solid #f1f5f9;">
                    <span class="text-4xl font-black text-slate-900">Rs. 0</span>
                    <span class="text-sm font-semibold text-slate-400">/ forever</span>
                </div>

                <ul class="space-y-3.5 text-sm text-slate-600">
                    @foreach([
                        'Access to Free Content Library (/learn)',
                        'Participate in Community Feed discussions & polls',
                        'Earn Activity Points & Community Badges',
                        'Weekly Leaderboard tracking',
                    ] as $feature)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 fp-check-green shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">{{ $feature }}</span>
                        </li>
                    @endforeach
                    @foreach([
                        'Full Course Masterclasses & Quizzes',
                        'Verifiable PDF Course Certificates',
                        'Institutional Financial Research Summaries',
                    ] as $locked)
                        <li class="flex items-start gap-3 text-slate-400">
                            <svg class="w-5 h-5 text-slate-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="font-medium">{{ $locked }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="pt-8">
                @if(!auth()->check())
                    <a href="{{ route('register') }}" wire:navigate
                        class="w-full block text-center py-3 px-4 rounded-xl border-2 font-bold text-sm text-slate-700 hover:text-[#28a04a] transition-colors"
                        style="border-color:rgba(57,229,84,0.3); hover:border-color:rgba(57,229,84,0.6);">
                        Create Free Account
                    </a>
                @elseif(!$hasActiveSubscription)
                    <button disabled
                        class="w-full py-3 px-4 rounded-xl font-bold text-sm text-slate-400 cursor-default"
                        style="background:#f1f5f9;">
                        Current Plan
                    </button>
                @else
                    <span class="block text-center text-xs text-slate-400 py-2 font-medium">Included with your membership</span>
                @endif
            </div>
        </div>

        {{-- Pro Card --}}
        <div class="fp-pricing-pro rounded-2xl p-8 flex flex-col justify-between relative overflow-hidden">
            {{-- Glow orb --}}
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full blur-3xl pointer-events-none"
                style="background:rgba(57,229,84,0.15);"></div>
            <div class="absolute -bottom-12 -left-12 w-36 h-36 rounded-full blur-2xl pointer-events-none"
                style="background:rgba(40,160,74,0.1);"></div>

            {{-- Most Popular Badge --}}
            <div class="absolute -top-3.5 right-6 z-10">
                <span class="text-slate-950 text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                    Most Popular
                </span>
            </div>

            <div class="space-y-6 relative z-10">
                <div>
                    <h3 class="text-xl font-black text-white flex items-center gap-2">
                        Paid Subscriber
                        <span class="text-[#39E554] text-sm">👑</span>
                    </h3>
                    <p class="text-xs text-white/50 mt-1 font-medium">Full access to professional education &amp; financial intelligence</p>
                </div>

                <div class="flex items-baseline gap-1 pb-6" style="border-bottom:1px solid rgba(57,229,84,0.15);">
                    <span class="text-4xl font-black text-white">Rs. {{ number_format($price) }}</span>
                    <span class="text-sm font-semibold text-white/40">/ month ({{ $durationDays }} days)</span>
                </div>

                <ul class="space-y-3.5 text-sm text-white/80">
                    @foreach([
                        'Everything in Free tier plus:',
                        'Full LMS Course Catalog & Sequential Chapters',
                        'Interactive chapter quizzes & assessments (70% pass threshold)',
                        'Verifiable PDF Completion Certificates with unique IDs',
                        'Full Institutional Financial Research Summaries',
                        'Interactive Live Sessions & webinars with financial instructors',
                    ] as $feature)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 fp-check-green shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            @if($loop->first)
                                <span class="font-black text-white">{{ $feature }}</span>
                            @else
                                <span class="font-medium">{{ $feature }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="pt-8 relative z-10">
                @if($hasActiveSubscription)
                    <div class="text-center space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold w-full justify-center"
                            style="background:rgba(57,229,84,0.15); color:#39E554; border:1px solid rgba(57,229,84,0.3);">
                            ✓ Your Subscription is Active
                        </span>
                        @if($activeSubscription)
                            <p class="text-[11px] text-white/40 font-medium">
                                Current period ends {{ $activeSubscription->ends_at->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                @else
                    <button wire:click="subscribe" wire:loading.attr="disabled"
                        class="w-full py-3.5 px-6 rounded-xl text-slate-950 font-black text-base transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        style="background:linear-gradient(135deg,#39E554,#28a04a); box-shadow:0 8px 24px rgba(57,229,84,0.4);">
                        <span wire:loading.remove wire:target="subscribe">
                            {{ auth()->check() ? 'Subscribe Now — Rs. '.number_format($price).'/mo' : 'Log In & Subscribe' }}
                        </span>
                        <span wire:loading wire:target="subscribe" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-slate-950" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Connecting to Safepay Checkout...
                        </span>
                    </button>
                    <p class="text-center text-[11px] text-white/35 mt-2 font-medium">
                        🔒 Safe &amp; encrypted payment via Safepay (cards, bank, mobile wallets). Cancel anytime.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Trust Footer --}}
    <div class="rounded-2xl p-6 sm:p-8 max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 text-sm text-slate-600"
        style="background:#fff; border:1px solid rgba(226,232,240,0.8); box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0"
                style="background:rgba(57,229,84,0.1);">🛡️</div>
            <div>
                <h4 class="font-black text-slate-900">State Bank of Pakistan Regulated Gateway</h4>
                <p class="text-xs text-slate-500 font-medium">Payments processed through Safepay using 256-bit encryption. Your credentials never touch FinPulse servers.</p>
            </div>
        </div>
        <div class="flex items-center gap-4 shrink-0 text-xs font-bold text-slate-500">
            <span>Debit / Credit Cards</span>
            <span class="text-slate-300">•</span>
            <span>Bank Transfers</span>
            <span class="text-slate-300">•</span>
            <span>Wallets</span>
        </div>
    </div>

</div>
