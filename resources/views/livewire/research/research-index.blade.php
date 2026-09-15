<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 text-xs font-bold uppercase tracking-wider rounded bg-[#0B1A33] text-[#C89B3C]">Institutional Analysis</span>
                <span class="text-xs text-gray-500 font-medium">FinPulse Intelligence & Macro Research</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0B1A33] tracking-tight font-serif">
                Research Summaries & Market Briefs
            </h1>
            <p class="mt-2 text-base text-gray-600 max-w-2xl">
                Rigorous financial research, macroeconomic breakdowns, and valuation methodologies compiled by verified market analysts.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @can('content.publish')
                <a href="{{ route('research.create') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0B1A33] text-white font-semibold text-sm hover:bg-[#13274c] shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4 text-[#C89B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Publish Research
                </a>
            @endcan
        </div>
    </div>

    {{-- Filters & Search Bar --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search research by keyword..."
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all shadow-sm">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0">
            <button wire:click="$set('tier', 'all')"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $tier === 'all' ? 'bg-[#0B1A33] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                All Tiers
            </button>
            @foreach($tiers as $tierOption)
                <button wire:click="$set('tier', '{{ $tierOption->value }}')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $tier === $tierOption->value ? 'bg-[#0B1A33] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ ucfirst($tierOption->value) }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Research Cards Grid --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($items as $item)
            @php
                $isFree = $item->tier->value === 'free';
                $isRegistered = $item->tier->value === 'registered';
                $isPaid = $item->tier->value === 'paid';
                $userCanAccess = $isFree || (auth()->check() && ($isRegistered || auth()->user()->hasRole(['Paid Subscriber', 'Instructor', 'Admin'])));
            @endphp
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                <div class="p-6">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wider
                            {{ $isFree ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($isPaid ? 'bg-amber-50 text-[#C89B3C] border border-[#C89B3C]/30' : 'bg-blue-50 text-blue-700 border border-blue-200') }}">
                            {{ ucfirst($item->tier->value) }}
                        </span>
                        <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $item->duration_minutes ?? 5 }} min read
                        </span>
                    </div>

                    <a href="{{ route('research.show', $item->slug) }}" wire:navigate class="block group">
                        <h2 class="text-xl font-bold text-[#0B1A33] font-serif group-hover:text-[#C89B3C] transition-colors line-clamp-2 leading-snug">
                            {{ $item->title }}
                        </h2>
                    </a>

                    {{-- Executive Summary Callout --}}
                    <div class="mt-4 p-3 bg-gray-50 rounded-xl border-l-4 border-[#0B1A33]">
                        <p class="text-xs font-semibold text-[#0B1A33] uppercase tracking-wider mb-1">Executive Summary</p>
                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($item->body), 150) }}
                        </p>
                    </div>

                    {{-- Gating / Access indicator --}}
                    @if(!$userCanAccess)
                        <div class="mt-4 p-3 rounded-xl bg-amber-50/70 border border-amber-200/70 text-xs text-amber-800 flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div>
                                @if(!auth()->check())
                                    <span>Full report requires {{ $isPaid ? 'a Paid subscription' : 'free registration' }}. <a href="{{ route('login') }}" class="font-bold underline text-[#0B1A33]">Log in</a> or <a href="{{ route('register') }}" class="font-bold underline text-[#C89B3C]">sign up</a>.</span>
                                @else
                                    <span>Institutional tier summary. Premium subscription required to unlock complete financial models.</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-[#0B1A33] text-white flex items-center justify-center font-bold text-[10px]">
                            {{ strtoupper(substr($item->author->name ?? 'FP', 0, 1)) }}
                        </div>
                        <span class="font-medium text-gray-700 truncate max-w-[120px]">{{ $item->author->name ?? 'FinPulse Research' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>{{ $item->published_at?->format('M d, Y') ?? 'Recent' }}</span>
                        <a href="{{ route('research.show', $item->slug) }}" wire:navigate
                            class="font-semibold text-[#0B1A33] group-hover:text-[#C89B3C] transition-colors flex items-center gap-0.5">
                            Read
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-200">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-base font-bold text-[#0B1A33]">No research summaries found</h3>
                <p class="text-sm text-gray-500 mt-1">Try adjusting your tier filter or search keywords.</p>
                @if($tier !== 'all' || $search !== '')
                    <button wire:click="resetFilters" class="mt-4 px-4 py-2 text-xs font-semibold text-[#0B1A33] bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
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
