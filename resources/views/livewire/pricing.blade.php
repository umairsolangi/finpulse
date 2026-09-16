<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-12">
    <!-- Header -->
    <div class="text-center space-y-4 max-w-3xl mx-auto fp-animate-in">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-300 shadow-sm">
            ✨ Transparent Financial Education
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-finpulse-navy tracking-tight leading-tight">
            Invest in Your Financial Mastery
        </h1>
        <p class="text-base sm:text-lg text-finpulse-gray leading-relaxed">
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

    <!-- Pricing Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch max-w-4xl mx-auto fp-stagger-grid">
        <!-- Free Member Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-finpulse-navy">Free Member</h3>
                    <p class="text-xs text-gray-500 mt-1">Foundational literacy & community engagement</p>
                </div>

                <div class="flex items-baseline gap-1 border-b border-gray-100 pb-6">
                    <span class="text-4xl font-extrabold text-finpulse-navy">Rs. 0</span>
                    <span class="text-sm font-medium text-gray-500">/ forever</span>
                </div>

                <ul class="space-y-3.5 text-sm text-gray-600">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Access to Free Content Library (<code class="text-xs bg-gray-100 px-1 py-0.5 rounded">/learn</code>)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Participate in Community Feed discussions & polls</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Earn Activity Points & Community Badges</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Weekly Leaderboard tracking</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-400">
                        <svg class="w-5 h-5 text-gray-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Full Course Masterclasses & Quizzes</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-400">
                        <svg class="w-5 h-5 text-gray-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Verifiable PDF Course Certificates</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-400">
                        <svg class="w-5 h-5 text-gray-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Institutional Financial Research Summaries</span>
                    </li>
                </ul>
            </div>

            <div class="pt-8">
                @if(!auth()->check())
                    <a
                        href="{{ route('register') }}"
                        wire:navigate
                        class="w-full block text-center py-3 px-4 rounded-xl border border-gray-300 font-bold text-sm text-finpulse-navy hover:bg-gray-50 transition-colors"
                    >
                        Create Free Account
                    </a>
                @elseif(!$hasActiveSubscription)
                    <button
                        disabled
                        class="w-full py-3 px-4 rounded-xl bg-gray-100 font-semibold text-sm text-gray-500 cursor-default"
                    >
                        Current Plan
                    </button>
                @else
                    <span class="block text-center text-xs text-gray-500 py-2">Included with your membership</span>
                @endif
            </div>
        </div>

        <!-- Paid Subscriber Card (Featured) -->
        <div class="relative bg-gradient-to-b from-[#0B1A33] to-[#081224] text-white rounded-2xl p-8 shadow-xl border-2 border-[#C89B3C] flex flex-col justify-between hover:shadow-2xl transition-all">
            <!-- Badge -->
            <div class="absolute -top-3.5 right-6">
                <span class="bg-gradient-to-r from-amber-400 to-[#C89B3C] text-finpulse-navy text-xs font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                    Most Popular
                </span>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        Paid Subscriber
                        <span class="text-amber-400 text-sm">👑</span>
                    </h3>
                    <p class="text-xs text-gray-300 mt-1">Full access to professional education & financial intelligence</p>
                </div>

                <div class="flex items-baseline gap-1 border-b border-gray-800 pb-6">
                    <span class="text-4xl font-extrabold text-white">Rs. {{ number_format($price) }}</span>
                    <span class="text-sm font-medium text-gray-400">/ month ({{ $durationDays }} days)</span>
                </div>

                <ul class="space-y-3.5 text-sm text-gray-200">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Everything in Free tier</strong> plus:</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Full LMS Course Catalog & Sequential Chapters</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Interactive chapter quizzes & assessments (70% pass threshold)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Verifiable PDF Completion Certificates streamed with unique IDs</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Full Institutional Financial Research Summaries</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Interactive Live Sessions & webinars with financial instructors</span>
                    </li>
                </ul>
            </div>

            <div class="pt-8">
                @if($hasActiveSubscription)
                    <div class="text-center space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-xl text-sm font-bold w-full justify-center">
                            ✓ Your Subscription is Active
                        </span>
                        @if($activeSubscription)
                            <p class="text-[11px] text-gray-400">
                                Current period ends {{ $activeSubscription->ends_at->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                @else
                    <button
                        wire:click="subscribe"
                        wire:loading.attr="disabled"
                        class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-amber-400 to-[#C89B3C] hover:from-amber-300 hover:to-amber-500 text-finpulse-navy font-extrabold text-base transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2"
                    >
                        <span wire:loading.remove wire:target="subscribe">
                            {{ auth()->check() ? 'Subscribe Now — Rs. '.number_format($price).'/mo' : 'Log In & Subscribe' }}
                        </span>
                        <span wire:loading wire:target="subscribe" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-finpulse-navy" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Connecting to Safepay Checkout...
                        </span>
                    </button>
                    <p class="text-center text-[11px] text-gray-400 mt-2">
                        🔒 Safe & encrypted payment via Safepay (cards, bank, mobile wallets). Cancel anytime.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Trust & Assurance Footer -->
    <div class="bg-gray-50 rounded-2xl border border-gray-200/80 p-6 sm:p-8 max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 text-sm text-gray-600">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                🛡️
            </div>
            <div>
                <h4 class="font-bold text-finpulse-navy">State Bank of Pakistan Regulated Gateway</h4>
                <p class="text-xs text-gray-500">Payments are processed directly through Safepay using 256-bit encryption. Your payment credentials never touch FinPulse servers.</p>
            </div>
        </div>
        <div class="flex items-center gap-4 shrink-0 text-xs font-semibold text-gray-500">
            <span>Debit / Credit Cards</span>
            <span>•</span>
            <span>Bank Transfers</span>
            <span>•</span>
            <span>Wallets</span>
        </div>
    </div>
</div>
