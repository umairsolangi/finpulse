<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="fp-animate-in">
        <a
            href="{{ route('learn.index') }}"
            wire:navigate
            class="inline-flex items-center gap-1 text-sm font-semibold text-finpulse-navy hover:text-[#C89B3C] transition-colors group"
        >
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Back to Free Content Library</span>
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6 fp-animate-in">
        <!-- Header Metadata -->
        @php
            $skillBadgeClass = match($item->skill_level?->value ?? $item->skill_level) {
                'beginner' => 'bg-amber-100 text-amber-900 border-amber-300',
                'intermediate' => 'bg-blue-100 text-finpulse-navy border-blue-200',
                'advanced' => 'bg-gray-100 text-gray-900 border-gray-300',
                default => 'bg-gray-100 text-gray-800 border-gray-200',
            };

            $isFreeTier = ($item->tier?->value ?? $item->tier) === 'free';
        @endphp

        <div class="space-y-4">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $skillBadgeClass }}">
                    {{ ucfirst($item->skill_level?->value ?? $item->skill_level ?? 'General') }}
                </span>

                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-finpulse-cream text-finpulse-navy border border-amber-200 uppercase tracking-wider">
                    {{ str_replace('_', ' ', ucfirst($item->type?->value ?? $item->type)) }}
                </span>

                @if(!$isFreeTier)
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-500 text-white uppercase tracking-wider shadow-sm">
                        {{ strtoupper($item->tier?->value ?? $item->tier) }} ACCESS
                    </span>
                @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                        FREE
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight leading-tight">
                {{ $item->title }}
            </h1>

            <div class="flex items-center gap-4 text-xs sm:text-sm text-finpulse-gray border-b border-gray-100 pb-4">
                @if($item->duration_minutes)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $item->duration_minutes }} minutes
                    </span>
                @endif

                @if($item->published_at)
                    <span>Published {{ $item->published_at->format('M d, Y') }}</span>
                @endif
            </div>
        </div>

        <!-- Content Body / Paywall Locked Teaser -->
        @if(!$isFreeTier)
            <!-- Locked Teaser State -->
            <div class="bg-gray-900 text-white rounded-xl p-8 text-center border border-gray-800 space-y-4 my-4 shadow-md fp-animate-in">
                <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto fp-float">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-white">
                    This content is locked
                </h3>

                <p class="text-sm text-gray-300 max-w-md mx-auto leading-relaxed">
                    @if(($item->tier?->value ?? $item->tier) === 'registered')
                        This tutorial requires a registered account. Please log in or create a free FinPulse account to unlock full access.
                    @else
                        This lesson is part of our premium financial curriculum. Upgrade your subscription to Paid Subscriber to unlock all premium courses and guides.
                    @endif
                </p>

                <div class="pt-3 flex items-center justify-center gap-3">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                        >
                            Log in to unlock
                        </a>
                        <a
                            href="{{ route('register') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm rounded-lg transition-all duration-300"
                        >
                            Create Account
                        </a>
                    @else
                        <a
                            href="{{ route('dashboard') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                        >
                            Upgrade Membership
                        </a>
                    @endguest
                </div>
            </div>
        @else
            <!-- Free Tier Full Content View -->
            @if(($item->type?->value ?? $item->type) === 'video')
                <!-- Video Player Placeholder Container -->
                <div class="space-y-6">
                    <!-- Connects to Mux/Cloudflare Stream in future release -->
                    <div class="relative w-full aspect-video bg-gray-900 rounded-xl overflow-hidden shadow-md flex items-center justify-center group border border-gray-800 fp-img-reveal">
                        <div class="text-center p-6 space-y-3">
                            <div class="w-16 h-16 rounded-full bg-[#C89B3C] text-finpulse-navy flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-200">Video Player Placeholder</p>
                            <p class="text-xs text-gray-400">Stream player integration ready for upcoming releases</p>
                        </div>
                    </div>

                    @if($item->body)
                        <div class="prose max-w-none text-gray-800 leading-relaxed space-y-4 text-sm sm:text-base">
                            {!! nl2br(e($item->body)) !!}
                        </div>
                    @endif
                </div>
            @else
                <!-- Article Content Layout -->
                <div class="prose max-w-none text-gray-800 leading-relaxed space-y-4 text-sm sm:text-base">
                    {!! nl2br(e($item->body)) !!}
                </div>
            @endif
        @endif
    </div>
</div>
