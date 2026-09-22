<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .fp-research-card {
            background:#fff; border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 1px 4px rgba(0,0,0,0.04);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative; overflow: hidden;
        }
        .fp-research-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,#39E554,#28a04a); opacity:0; transition:opacity 0.3s;
        }
        .fp-research-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(57,229,84,0.15); border-color:rgba(57,229,84,0.3); }
        .fp-research-card:hover::before { opacity:1; }
        .fp-tier-btn-active { background:linear-gradient(135deg,#39E554,#32d44b); color:#0F172A; box-shadow:0 4px 14px rgba(57,229,84,0.3); }
        .fp-tier-btn { background:#f1f5f9; color:#64748b; }
        .fp-tier-btn:hover { background:#e2e8f0; color:#1e293b; }
        .section-label {
            font-size:0.65rem; font-weight:800; letter-spacing:0.15em;
            text-transform:uppercase; color:#28a04a;
        }
    </style>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8" style="border-bottom:1px solid rgba(226,232,240,0.8);">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.18em] rounded-lg text-slate-950"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">Institutional Analysis</span>
                <span class="text-xs text-slate-500 font-semibold">FinPulse Intelligence &amp; Macro Research</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Research <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Summaries</span> &amp; Market Briefs
            </h1>
            <p class="mt-2 text-base text-slate-500 max-w-2xl leading-relaxed font-medium">
                Rigorous financial research, macroeconomic breakdowns, and valuation methodologies compiled by verified market analysts.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @can('content.publish')
                <a href="{{ route('research.create') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-slate-950 font-bold text-sm shadow transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Publish Research
                </a>
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search research by keyword..."
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:ring-2 focus:border-transparent transition-all shadow-sm"
                style="--tw-ring-color:rgba(57,229,84,0.4);">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0">
            <button wire:click="$set('tier', 'all')"
                class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ $tier === 'all' ? 'fp-tier-btn-active' : 'fp-tier-btn' }}">
                All Tiers
            </button>
            @foreach($tiers as $tierOption)
                <button wire:click="$set('tier', '{{ $tierOption->value }}')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ $tier === $tierOption->value ? 'fp-tier-btn-active' : 'fp-tier-btn' }}">
                    {{ ucfirst($tierOption->value) }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Cards Grid --}}
    <p class="section-label mt-8 mb-4">{{ $items->total() }} Reports</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($items as $item)
            @php
                $isFree        = $item->tier->value === 'free';
                $isRegistered  = $item->tier->value === 'registered';
                $isPaid        = $item->tier->value === 'paid';
                $userCanAccess = $isFree || (auth()->check() && ($isRegistered || auth()->user()->hasPaidAccess()));
            @endphp
            <div class="fp-research-card rounded-2xl flex flex-col justify-between group">
                <div class="p-6">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-xs font-bold uppercase tracking-wider
                            {{ $isFree ? 'bg-emerald-50 text-[#28a04a] border border-emerald-200' : ($isPaid ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200') }}">
                            {{ ucfirst($item->tier->value) }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $item->duration_minutes ?? 5 }} min read
                        </span>
                    </div>

                    <h3 class="font-bold text-lg text-slate-900 group-hover:text-[#28a04a] transition-colors leading-snug line-clamp-2">
                        <a href="{{ route('research.show', $item->slug) }}" wire:navigate>{{ $item->title }}</a>
                    </h3>

                    <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                        {{ $item->summary ?? Str::limit(strip_tags($item->body), 120) }}
                    </p>

                    @if(!$userCanAccess)
                        <div class="mt-4 p-3 rounded-xl text-xs flex items-start gap-2"
                            style="background:rgba(251,191,36,0.08); border:1px solid rgba(251,191,36,0.3); color:#92400e;">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div>
                                @if(!auth()->check())
                                    <span>Full report requires {{ $isPaid ? 'a Paid subscription' : 'free registration' }}.
                                        <a href="{{ route('login') }}" class="font-bold underline text-slate-700">Log in</a> or
                                        <a href="{{ route('register') }}" class="font-bold underline text-[#28a04a]">sign up</a>.
                                    </span>
                                @else
                                    <span>Institutional tier summary.
                                        <a href="{{ route('pricing') }}" class="font-bold underline text-[#28a04a]">Upgrade to Paid</a> to unlock complete financial models.
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 flex items-center justify-between text-xs text-slate-500"
                    style="background:#f8fafc; border-top:1px solid rgba(226,232,240,0.8);">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-xl flex items-center justify-center font-black text-[10px] text-slate-950"
                            style="background:linear-gradient(135deg,#39E554,#28a04a);">
                            {{ strtoupper(substr($item->author->name ?? 'FP', 0, 1)) }}
                        </div>
                        <span class="font-semibold text-slate-700 truncate max-w-[120px]">{{ $item->author->name ?? 'FinPulse Research' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>{{ $item->published_at?->format('M d, Y') ?? 'Recent' }}</span>
                        <a href="{{ route('research.show', $item->slug) }}" wire:navigate
                            class="font-bold text-slate-700 group-hover:text-[#28a04a] transition-colors flex items-center gap-0.5">
                            Read
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl" style="border:1px solid rgba(226,232,240,0.8);">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl"
                    style="background:rgba(57,229,84,0.1);">📄</div>
                <h3 class="text-base font-bold text-slate-900">No research summaries found</h3>
                <p class="text-sm text-slate-500 mt-1">Try adjusting your tier filter or search keywords.</p>
                @if($tier !== 'all' || $search !== '')
                    <button wire:click="resetFilters"
                        class="mt-4 px-5 py-2 text-xs font-bold rounded-xl text-slate-950 shadow transition-colors"
                        style="background:linear-gradient(135deg,#39E554,#28a04a);">
                        Reset Filters
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $items->links() }}
    </div>
</div>
