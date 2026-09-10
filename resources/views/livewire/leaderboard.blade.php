<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6" x-data="leaderboardAnimations()">
    <!-- Infinite Marquee / Loop Animation Ticker -->
    @if($topPoints->isNotEmpty())
        <div
            class="relative overflow-hidden bg-gradient-to-r from-finpulse-navy via-[#0f2446] to-finpulse-navy text-white rounded-xl shadow-sm border border-white/10 py-2.5 px-4 fp-marquee-container">
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#C89B3C] text-finpulse-navy shrink-0 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span> Live Ticker
                </span>
                <div class="overflow-hidden whitespace-nowrap w-full relative">
                    <div
                        class="inline-block animate-marquee will-change-transform text-xs sm:text-sm font-medium text-white/90">
                        @foreach($topPoints as $idx => $item)
                            <span class="inline-flex items-center gap-1.5 mx-4">
                                <span class="text-[#C89B3C] font-bold">#{{ $idx + 1 }}</span>
                                <span class="font-semibold">{{ $item->user->name ?? 'User' }}</span>
                                <span class="text-white/60">({{ $item->points }} pts)</span>
                                <span class="text-white/30">•</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Header & Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <!-- Text Wave / SplitText Title -->
            <h1 class="text-2xl sm:text-3xl font-extrabold text-finpulse-navy fp-text-wave flex items-center gap-2"
                id="leaderboard-title">
                <span>Weekly</span>
                <span class="text-[#C89B3C]">Leaderboard</span>
                <span class="text-2xl">🏆</span>
            </h1>
            <p class="text-sm text-finpulse-gray mt-1">
                Top community members ranked by activity for <span
                    class="font-semibold text-finpulse-navy">{{ $weekRange }}</span>
            </p>
        </div>

        <!-- View Mode Switcher (Triggers GSAP FLIP Layout Animation) -->
        <div class="inline-flex items-center p-1 rounded-xl bg-gray-100 border border-gray-200 self-start sm:self-auto">
            <button type="button" wire:click="setViewMode('list')" @click="triggerFlip()"
                class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 {{ $viewMode === 'list' ? 'bg-white text-finpulse-navy shadow-sm' : 'text-gray-600 hover:text-finpulse-navy' }}">
                Rank List
            </button>
            <button type="button" wire:click="setViewMode('podium')" @click="triggerFlip()"
                class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-all duration-200 {{ $viewMode === 'podium' ? 'bg-white text-finpulse-navy shadow-sm' : 'text-gray-600 hover:text-finpulse-navy' }}">
                Podium Cards
            </button>
        </div>
    </div>

    <!-- Top 3 Podium Cards (Rendered in podium mode or top highlight) -->
    @if($viewMode === 'podium' && $topPoints->count() >= 3)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 pb-2 fp-stagger-grid" id="podium-grid">
            <!-- 2nd Place -->
            @php $second = $topPoints->get(1); @endphp
            @if($second)
                <div
                    class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 text-center flex flex-col items-center justify-between order-2 md:order-1 {{ $second->user_id === auth()->id() ? 'ring-2 ring-[#C89B3C] bg-amber-50/20' : '' }}">
                    <div
                        class="w-16 h-16 rounded-full bg-slate-100 border-4 border-slate-300 flex items-center justify-center font-extrabold text-xl text-slate-700 shadow-inner">
                        🥈 2
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-gray-900 text-base">{{ $second->user->name ?? 'User' }}</h3>
                        @if($second->user && $second->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($second->user->badges as $badge)
                                    <span
                                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 w-full">
                        <span class="text-2xl font-black text-finpulse-navy">{{ $second->points }}</span>
                        <span class="text-xs text-gray-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif

            <!-- 1st Place Champion -->
            @php $first = $topPoints->get(0); @endphp
            @if($first)
                <div
                    class="bg-gradient-to-b from-amber-50/80 to-white rounded-2xl p-6 border-2 border-[#C89B3C] shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 text-center flex flex-col items-center justify-between order-1 md:order-2 md:-mt-4 relative {{ $first->user_id === auth()->id() ? 'ring-2 ring-[#C89B3C]' : '' }}">
                    <div
                        class="absolute -top-3 bg-[#C89B3C] text-finpulse-navy text-[11px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">
                        👑 Top Performer
                    </div>
                    <div
                        class="w-20 h-20 rounded-full bg-amber-100 border-4 border-[#C89B3C] flex items-center justify-center font-extrabold text-2xl text-amber-900 shadow-md">
                        🥇 1
                    </div>
                    <div class="mt-4">
                        <h3 class="font-extrabold text-gray-900 text-lg">{{ $first->user->name ?? 'User' }}</h3>
                        @if($first->user && $first->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($first->user->badges as $badge)
                                    <span
                                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 border-t border-amber-200/50 w-full">
                        <span class="text-3xl font-black text-[#C89B3C]">{{ $first->points }}</span>
                        <span class="text-xs text-gray-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif

            <!-- 3rd Place -->
            @php $third = $topPoints->get(2); @endphp
            @if($third)
                <div
                    class="bg-white rounded-2xl p-6 border-2 border-amber-700/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 text-center flex flex-col items-center justify-between order-3 md:order-3 {{ $third->user_id === auth()->id() ? 'ring-2 ring-[#C89B3C] bg-amber-50/20' : '' }}">
                    <div
                        class="w-16 h-16 rounded-full bg-amber-50 border-4 border-amber-700/40 flex items-center justify-center font-extrabold text-xl text-amber-900 shadow-inner">
                        🥉 3
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold text-gray-900 text-base">{{ $third->user->name ?? 'User' }}</h3>
                        @if($third->user && $third->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($third->user->badges as $badge)
                                    <span
                                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 w-full">
                        <span class="text-2xl font-black text-finpulse-navy">{{ $third->points }}</span>
                        <span class="text-xs text-gray-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Leaderboard Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" id="leaderboard-table-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="border-b border-gray-200 bg-gray-50/75 text-xs font-bold uppercase tracking-wider text-finpulse-gray">
                        <th class="py-4 px-4 sm:px-6 w-16 text-center">Rank</th>
                        <th class="py-4 px-4 sm:px-6">Member</th>
                        <th class="py-4 px-4 sm:px-6 text-right">Weekly Points</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm fp-stagger-table" id="leaderboard-tbody">
                    @forelse($topPoints as $index => $item)
                        @php
                            $rank = $index + 1;
                            $isMe = $item->user_id === auth()->id();
                            $rankMedal = match ($rank) {
                                1 => '🥇',
                                2 => '🥈',
                                3 => '🥉',
                                default => null,
                            };
                        @endphp
                        <tr class="transition-all duration-200 fp-leaderboard-row {{ $isMe ? 'bg-amber-50/70 border-l-4 border-l-[#C89B3C] font-semibold' : 'hover:bg-gray-50/80' }}"
                            data-rank="{{ $rank }}">
                            <!-- Position -->
                            <td class="py-4 px-4 sm:px-6 text-center font-bold">
                                @if($rankMedal)
                                    <span class="text-lg" title="Rank {{ $rank }}">{{ $rankMedal }}</span>
                                @else
                                    <span class="text-gray-500 text-sm font-semibold">#{{ $rank }}</span>
                                @endif
                            </td>

                            <!-- Member Name & Badges -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-finpulse-navy text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm {{ $isMe ? 'ring-2 ring-[#C89B3C]' : '' }}">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-gray-900 font-bold {{ $isMe ? 'text-[#0B1A33]' : '' }}">
                                                {{ $item->user->name ?? 'User' }}
                                            </span>
                                            @if($isMe)
                                                <span
                                                    class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-[#C89B3C] text-finpulse-navy">
                                                    You
                                                </span>
                                            @endif

                                            <!-- User Badges -->
                                            @if($item->user && $item->user->badges->isNotEmpty())
                                                @foreach($item->user->badges as $badge)
                                                    <span title="{{ $badge->name }}: {{ $badge->description }}"
                                                        class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 hover:scale-105 transition-transform">
                                                        🏆 {{ $badge->name }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Points -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <span class="font-extrabold text-base text-finpulse-navy">{{ $item->points }}</span>
                                <span class="text-xs text-gray-500 font-normal">pts</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 px-4 text-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                    ⚡
                                </div>
                                <h4 class="font-bold text-gray-800 text-base">No weekly activity recorded yet</h4>
                                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Be the very first to post, comment,
                                    or react this week to claim the #1 spot on the leaderboard!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Logged-in User Outside Top 20 Callout -->
        @if(!$isInTop20)
            <div
                class="p-4 sm:p-5 bg-gradient-to-r from-slate-900 via-finpulse-navy to-slate-900 text-white border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 fp-animate-in">
                <div class="flex items-center gap-3 text-center sm:text-left">
                    <div
                        class="w-10 h-10 rounded-full bg-[#C89B3C] text-finpulse-navy flex items-center justify-center font-black text-sm shrink-0 shadow-md">
                        #{{ $myRank }}
                    </div>
                    <div>
                        <div class="font-bold text-sm sm:text-base">
                            You're #{{ $myRank }} this week
                        </div>
                        <div class="text-xs text-white/70 mt-0.5">
                            You have earned <strong class="text-[#C89B3C]">{{ $myPoints }} points</strong> this week. Keep
                            engaging to climb into the top 20!
                        </div>
                    </div>
                </div>
                <a href="{{ route('feed') }}" wire:navigate
                    class="px-4 py-2 bg-[#C89B3C] hover:bg-[#d4a942] text-finpulse-navy font-bold text-xs rounded-lg transition-all duration-200 shadow-sm shrink-0">
                    Participate in Feed &rarr;
                </a>
            </div>
        @endif
    </div>

    <!-- Interactive GSAP & FLIP Animations Script -->
    <script>
        function leaderboardAnimations() {
            return {
                init() {
                    this.$nextTick(() => {
                        this.runEntrance();
                    });
                },
                runEntrance() {
                    if (typeof gsap === 'undefined') return;

                    // 1. Staggered Entrance Animation for table rows
                    gsap.fromTo('.fp-leaderboard-row',
                        { opacity: 0, x: -20 },
                        {
                            opacity: 1,
                            x: 0,
                            duration: 0.4,
                            stagger: 0.04,
                            ease: 'power2.out',
                        }
                    );

                    // 2. Text wave animation on title
                    const title = document.getElementById('leaderboard-title');
                    if (title && !title.dataset.animated) {
                        title.dataset.animated = 'true';
                        gsap.fromTo(title.children,
                            { opacity: 0, y: 15 },
                            {
                                opacity: 1,
                                y: 0,
                                duration: 0.5,
                                stagger: 0.1,
                                ease: 'back.out(1.7)'
                            }
                        );
                    }
                },
                triggerFlip() {
                    if (typeof gsap === 'undefined') return;
                    const container = document.getElementById('leaderboard-table-card');
                    if (container) {
                        gsap.fromTo(container,
                            { opacity: 0.4, scale: 0.98 },
                            { opacity: 1, scale: 1, duration: 0.35, ease: 'power2.out' }
                        );
                    }
                }
            };
        }
    </script>
</div>