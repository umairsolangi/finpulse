<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6" x-data="leaderboardAnimations()" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .fp-ticker {
            background:linear-gradient(135deg,#0a1628,#0B1A33);
            border:1px solid rgba(57,229,84,0.2);
            box-shadow:0 2px 12px rgba(57,229,84,0.1);
        }
        .fp-podium-card {
            background:#fff; border:2px solid rgba(226,232,240,0.9);
            box-shadow:0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
        }
        .fp-podium-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(57,229,84,0.15); border-color:rgba(57,229,84,0.4); }
        .fp-podium-champion {
            background:linear-gradient(160deg,#f0fdf4,#dcfce7);
            border:2px solid rgba(57,229,84,0.5);
            box-shadow:0 8px 32px rgba(57,229,84,0.25);
        }
        .fp-podium-champion:hover { transform:translateY(-8px); box-shadow:0 20px 50px rgba(57,229,84,0.35); }
        .fp-leaderboard-table { background:#fff; border:1px solid rgba(226,232,240,0.8); box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .fp-my-row { background:rgba(57,229,84,0.06); border-left:4px solid #39E554; }
        .fp-view-toggle { background:#fff; border:1px solid rgba(226,232,240,0.8); }
        .fp-view-active { background:linear-gradient(135deg,#39E554,#32d44b); color:#0F172A; box-shadow:0 3px 10px rgba(57,229,84,0.3); }
        .section-label { font-size:0.65rem; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:#28a04a; }
    </style>

    {{-- Live Ticker --}}
    @if($topPoints->isNotEmpty())
        <div class="fp-ticker rounded-2xl py-2.5 px-4 fp-marquee-container">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider shrink-0"
                    style="background:linear-gradient(135deg,#39E554,#28a04a); color:#0F172A;">
                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span> Live
                </span>
                <div class="overflow-hidden whitespace-nowrap w-full relative">
                    <div class="inline-block animate-marquee will-change-transform text-xs sm:text-sm font-medium text-white/80">
                        @foreach($topPoints as $idx => $item)
                            <span class="inline-flex items-center gap-1.5 mx-4">
                                <span class="text-[#39E554] font-black">#{{ $idx + 1 }}</span>
                                <span class="font-bold text-white">{{ $item->user->name ?? 'User' }}</span>
                                <span class="text-white/50">({{ $item->points }} pts)</span>
                                <span class="text-white/20">•</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Header & Controls --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="section-label mb-1">Rankings</p>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 fp-text-wave flex items-center gap-2" id="leaderboard-title">
                <span>Weekly</span>
                <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Leaderboard</span>
                <span class="text-2xl">🏆</span>
            </h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">
                Top community members ranked by activity for
                <span class="font-bold text-slate-700">{{ $weekRange }}</span>
            </p>
        </div>

        <div class="fp-view-toggle inline-flex items-center p-1 rounded-xl self-start sm:self-auto">
            <button type="button" wire:click="setViewMode('list')" @click="triggerFlip()"
                class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all duration-200 {{ $viewMode === 'list' ? 'fp-view-active' : 'text-slate-500 hover:text-slate-800' }}">
                Rank List
            </button>
            <button type="button" wire:click="setViewMode('podium')" @click="triggerFlip()"
                class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all duration-200 {{ $viewMode === 'podium' ? 'fp-view-active' : 'text-slate-500 hover:text-slate-800' }}">
                Podium Cards
            </button>
        </div>
    </div>

    {{-- Podium View --}}
    @if($viewMode === 'podium' && $topPoints->count() >= 3)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 pb-2 fp-stagger-grid" id="podium-grid">

            {{-- 2nd Place --}}
            @php $second = $topPoints->get(1); @endphp
            @if($second)
                <div class="fp-podium-card rounded-2xl p-6 text-center flex flex-col items-center justify-between order-2 md:order-1
                    {{ $second->user_id === auth()->id() ? 'border-[#39E554]/50' : '' }}">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 border-4 border-slate-300 flex items-center justify-center font-black text-xl text-slate-600 shadow-inner">🥈 2</div>
                    <div class="mt-4">
                        <h3 class="font-black text-slate-900 text-base">{{ $second->user->name ?? 'User' }}</h3>
                        @if($second->user && $second->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($second->user->badges as $badge)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                        style="background:rgba(57,229,84,0.1); color:#28a04a; border:1px solid rgba(57,229,84,0.2);">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 w-full" style="border-top:1px solid #f1f5f9;">
                        <span class="text-2xl font-black text-slate-900">{{ $second->points }}</span>
                        <span class="text-xs text-slate-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif

            {{-- 1st Place --}}
            @php $first = $topPoints->get(0); @endphp
            @if($first)
                <div class="fp-podium-champion rounded-2xl p-6 text-center flex flex-col items-center justify-between order-1 md:order-2 md:-mt-4 relative
                    {{ $first->user_id === auth()->id() ? 'ring-2 ring-[#39E554]' : '' }}">
                    <div class="absolute -top-3 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-widest text-slate-950"
                        style="background:linear-gradient(135deg,#39E554,#28a04a);">
                        👑 Top Performer
                    </div>
                    <div class="w-20 h-20 rounded-2xl border-4 flex items-center justify-center font-black text-2xl shadow-lg"
                        style="background:rgba(57,229,84,0.15); border-color:rgba(57,229,84,0.4);">🥇 1</div>
                    <div class="mt-4">
                        <h3 class="font-black text-slate-900 text-lg">{{ $first->user->name ?? 'User' }}</h3>
                        @if($first->user && $first->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($first->user->badges as $badge)
                                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full text-slate-950"
                                        style="background:linear-gradient(135deg,#39E554,#28a04a);">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 w-full" style="border-top:1px solid rgba(57,229,84,0.2);">
                        <span class="text-3xl font-black  bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">{{ $first->points }}</span>
                        <span class="text-xs text-slate-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif

            {{-- 3rd Place --}}
            @php $third = $topPoints->get(2); @endphp
            @if($third)
                <div class="fp-podium-card rounded-2xl p-6 text-center flex flex-col items-center justify-between order-3
                    {{ $third->user_id === auth()->id() ? 'border-[#39E554]/50' : '' }}">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 border-4 border-amber-300 flex items-center justify-center font-black text-xl text-amber-700 shadow-inner">🥉 3</div>
                    <div class="mt-4">
                        <h3 class="font-black text-slate-900 text-base">{{ $third->user->name ?? 'User' }}</h3>
                        @if($third->user && $third->user->badges->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mt-1.5">
                                @foreach($third->user->badges as $badge)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                        style="background:rgba(57,229,84,0.1); color:#28a04a; border:1px solid rgba(57,229,84,0.2);">
                                        {{ $badge->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-3 w-full" style="border-top:1px solid #f1f5f9;">
                        <span class="text-2xl font-black text-slate-900">{{ $third->points }}</span>
                        <span class="text-xs text-slate-500 font-medium">pts this week</span>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Leaderboard Table --}}
    <div class="fp-leaderboard-table rounded-2xl overflow-hidden" id="leaderboard-table-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black uppercase tracking-widest" style="background:#f8fafc; border-bottom:1px solid rgba(226,232,240,0.8); color:#94a3b8;">
                        <th class="py-4 px-4 sm:px-6 w-16 text-center">Rank</th>
                        <th class="py-4 px-4 sm:px-6">Member</th>
                        <th class="py-4 px-4 sm:px-6 text-right">Weekly Points</th>
                    </tr>
                </thead>
                <tbody class="divide-y fp-stagger-table" id="leaderboard-tbody" style="divide-color:rgba(226,232,240,0.6);">
                    @forelse($topPoints as $index => $item)
                        @php
                            $rank = $index + 1;
                            $isMe = $item->user_id === auth()->id();
                            $rankMedal = match ($rank) { 1 => '🥇', 2 => '🥈', 3 => '🥉', default => null };
                        @endphp
                        <tr class="transition-all duration-200 fp-leaderboard-row {{ $isMe ? 'fp-my-row' : 'hover:bg-slate-50/80' }}"
                            data-rank="{{ $rank }}">
                            <td class="py-4 px-4 sm:px-6 text-center font-black">
                                @if($rankMedal)
                                    <span class="text-lg" title="Rank {{ $rank }}">{{ $rankMedal }}</span>
                                @else
                                    <span class="text-slate-400 text-sm font-bold">#{{ $rank }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-xs shrink-0 text-slate-950"
                                        style="background:linear-gradient(135deg,#39E554,#28a04a); {{ $isMe ? 'box-shadow:0 0 0 2px rgba(57,229,84,0.4);' : '' }}">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-slate-900 font-bold">{{ $item->user->name ?? 'User' }}</span>
                                            @if($isMe)
                                                <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full text-slate-950"
                                                    style="background:linear-gradient(135deg,#39E554,#28a04a);">You</span>
                                            @endif
                                            @if($item->user && $item->user->badges->isNotEmpty())
                                                @foreach($item->user->badges as $badge)
                                                    <span title="{{ $badge->name }}: {{ $badge->description }}"
                                                        class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full border hover:scale-105 transition-transform"
                                                        style="background:rgba(57,229,84,0.1); border-color:rgba(57,229,84,0.2); color:#28a04a;">
                                                        🏆 {{ $badge->name }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <span class="font-black text-base text-slate-900">{{ $item->points }}</span>
                                <span class="text-xs text-slate-400 font-medium">pts</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 px-4 text-center">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl"
                                    style="background:rgba(57,229,84,0.1);">⚡</div>
                                <h4 class="font-black text-slate-800 text-base">No weekly activity recorded yet</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto font-medium">Be the very first to post, comment, or react this week to claim the #1 spot!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- User outside top 20 --}}
        @if(!$isInTop20)
            <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-3 fp-animate-in"
                style="background:linear-gradient(135deg,#0a1628,#0B1A33); border-top:1px solid rgba(57,229,84,0.15);">
                <div class="flex items-center gap-3 text-center sm:text-left">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm shrink-0 text-slate-950"
                        style="background:linear-gradient(135deg,#39E554,#28a04a); box-shadow:0 4px 12px rgba(57,229,84,0.4);">
                        #{{ $myRank }}
                    </div>
                    <div>
                        <div class="font-bold text-sm sm:text-base text-white">You're #{{ $myRank }} this week</div>
                        <div class="text-xs text-white/50 mt-0.5 font-medium">
                            You have earned <strong class="text-[#39E554]">{{ $myPoints }} points</strong> this week. Keep engaging to climb into the top 20!
                        </div>
                    </div>
                </div>
                <a href="{{ route('feed') }}" wire:navigate
                    class="px-5 py-2 text-slate-950 font-black text-xs rounded-xl transition-all hover:-translate-y-0.5 shadow-lg shrink-0"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                    Participate in Feed →
                </a>
            </div>
        @endif
    </div>

    <script>
        function leaderboardAnimations() {
            return {
                init() {
                    this.$nextTick(() => { this.runEntrance(); });
                },
                runEntrance() {
                    if (typeof gsap === 'undefined') return;
                    gsap.fromTo('.fp-leaderboard-row',
                        { opacity: 0, x: -20 },
                        { opacity: 1, x: 0, duration: 0.4, stagger: 0.04, ease: 'power2.out' }
                    );
                    const title = document.getElementById('leaderboard-title');
                    if (title && !title.dataset.animated) {
                        title.dataset.animated = 'true';
                        gsap.fromTo(title.children,
                            { opacity: 0, y: 15 },
                            { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'back.out(1.7)' }
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