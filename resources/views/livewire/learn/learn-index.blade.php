<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .page-bg-learn {
            background-color: #f0fdf4;
            background-image: radial-gradient(ellipse 70% 50% at 5% 0%, rgba(57,229,84,0.1) 0%, transparent 55%),
                              radial-gradient(ellipse 50% 40% at 95% 90%, rgba(40,160,74,0.07) 0%, transparent 55%);
        }
        .fp-filter-card { background:#fff; border:1px solid rgba(226,232,240,0.8); box-shadow:0 1px 4px rgba(0,0,0,0.04); }
        .fp-item-card {
            background:#fff; border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 1px 4px rgba(0,0,0,0.04);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative; overflow: hidden;
        }
        .fp-item-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,#39E554,#28a04a); opacity:0; transition:opacity 0.3s;
        }
        .fp-item-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(57,229,84,0.14); border-color:rgba(57,229,84,0.3); }
        .fp-item-card:hover::before { opacity:1; }
        .fp-tab-active { background:linear-gradient(135deg,#39E554,#32d44b); color:#0F172A; box-shadow:0 4px 14px rgba(57,229,84,0.35); }
        .fp-tab-inactive { background:#f1f5f9; color:#64748b; }
        .fp-tab-inactive:hover { background:#e2e8f0; color:#1e293b; }
        .section-label {
            font-size:0.65rem; font-weight:800; letter-spacing:0.15em;
            text-transform:uppercase; color:#28a04a;
        }
    </style>

    {{-- Header --}}
    <div class="text-center max-w-3xl mx-auto space-y-4 fp-animate-in">
        
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Free <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Knowledge Library</span>
        </h1>
        <p class="text-base text-slate-500 max-w-2xl mx-auto leading-relaxed font-medium">
            Short 3–5 minute explainers, written market glossaries, and structured foundational guides designed to help you master the PSX, mutual funds, and smart wealth compounding.
        </p>
    </div>

    {{-- Filter Bar --}}
    <div class="fp-filter-card rounded-2xl p-5 sm:p-6 space-y-5 fp-animate-in">
        {{-- Top Tabs --}}
        <div class="flex items-center justify-between flex-wrap gap-3 pb-4" style="border-bottom:1px solid #f1f5f9;">
            <div class="flex items-center gap-2">
                <button type="button" wire:click="$set('onlyBookmarks', false)"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ ! $onlyBookmarks ? 'fp-tab-active' : 'fp-tab-inactive' }}">
                    All Articles &amp; Guides
                </button>
                <button type="button" wire:click="toggleSavedFilter"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $onlyBookmarks ? 'fp-tab-active' : 'fp-tab-inactive' }}">
                    ⭐ Saved Reading List
                    @if(count($bookmarkedIds) > 0)
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $onlyBookmarks ? 'bg-white/30' : 'bg-slate-300/60 text-slate-600' }}">
                            {{ count($bookmarkedIds) }}
                        </span>
                    @endif
                </button>
            </div>
            @if(count($completedIds) > 0)
                <div class="text-xs font-bold px-3 py-1.5 rounded-xl flex items-center gap-1.5"
                    style="background:rgba(57,229,84,0.1); color:#28a04a; border:1px solid rgba(57,229,84,0.2);">
                    <span>✓</span>
                    <span>Completed <strong>{{ count($completedIds) }}</strong> {{ Str::plural('lesson', count($completedIds)) }}</span>
                </div>
            @endif
        </div>

        {{-- Filter Controls --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Search</label>
                <div class="relative">
                    <input id="search" type="text" wire:model.live.debounce.300ms="search" placeholder="Search topic or ticker..."
                        class="w-full rounded-xl border-slate-200 pl-9 text-xs sm:text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors" />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <label for="type" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Format</label>
                <select id="type" wire:model.live="type"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors">
                    <option value="all">All Formats</option>
                    @foreach($types as $t)
                        <option value="{{ $t->value }}">{{ str_replace('_', ' ', ucfirst($t->value)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="skillLevel" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Skill Level</label>
                <select id="skillLevel" wire:model.live="skillLevel"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors">
                    <option value="all">All Skill Levels</option>
                    @foreach($skillLevels as $level)
                        <option value="{{ $level->value }}">{{ ucfirst($level->value) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="language" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Language</label>
                <select id="language" wire:model.live="language"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors">
                    <option value="all">All Languages</option>
                    @foreach($languages as $lang)
                        <option value="{{ $lang->value }}">{{ $lang->value === 'en' ? 'English (with Urdu Mode)' : 'Urdu' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($type !== 'all' || $skillLevel !== 'all' || $language !== 'all' || $search !== '' || $onlyBookmarks)
            <div class="flex justify-end pt-2" style="border-top:1px solid #f1f5f9;">
                <button type="button" wire:click="resetFilters"
                    class="text-xs font-bold transition-colors" style="color:#28a04a;">
                    Reset All Filters
                </button>
            </div>
        @endif
    </div>

    {{-- Content Grid --}}
    <p class="section-label px-1">Articles &amp; Guides</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($items as $item)
            @php
                $skillBadge = match ($item->skill_level?->value ?? $item->skill_level) {
                    'beginner'     => ['bg' => 'bg-emerald-50 text-[#28a04a] border-emerald-200',  'label' => 'Beginner'],
                    'intermediate' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200',          'label' => 'Intermediate'],
                    'advanced'     => ['bg' => 'bg-purple-50 text-purple-700 border-purple-200',    'label' => 'Advanced'],
                    default        => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200',      'label' => 'General'],
                };
                $isBookmarked = in_array($item->id, $bookmarkedIds);
                $isCompleted  = in_array($item->id, $completedIds);
            @endphp

            <div class="fp-item-card rounded-2xl p-6 flex flex-col justify-between group space-y-4">
                <div class="space-y-3">
                    {{-- Badges Row --}}
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border {{ $skillBadge['bg'] }}">
                                {{ $skillBadge['label'] }}
                            </span>
                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 uppercase tracking-wider">
                                {{ str_replace('_', ' ', ucfirst($item->type?->value ?? $item->type)) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1 text-xs">
                            @if($isBookmarked)
                                <span class="text-amber-400 font-black text-sm" title="Saved">★</span>
                            @endif
                            @if($isCompleted)
                                <span class="px-2 py-0.5 rounded-full font-black text-[10px] flex items-center gap-0.5"
                                    style="background:rgba(57,229,84,0.12); color:#28a04a;">
                                    ✓ Read
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#28a04a] transition-colors leading-snug line-clamp-2">
                        <a href="{{ route('learn.show', $item->slug) }}" wire:navigate>{{ $item->title }}</a>
                    </h2>

                    {{-- Snippet --}}
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($item->body ?? 'Free financial educational content lesson.'), 140) }}
                    </p>

                    {{-- Micro pills --}}
                    <div class="flex items-center gap-2 text-[10px] text-slate-400 pt-1">
                        @if($item->key_takeaways)
                            <span class="bg-slate-50 px-2 py-0.5 rounded-lg border border-slate-100 font-medium">📌 Cheat Sheet</span>
                        @endif
                        @if($item->quiz_data)
                            <span class="bg-slate-50 px-2 py-0.5 rounded-lg border border-slate-100 font-medium">🧠 Quiz</span>
                        @endif
                        @if($item->urdu_body)
                            <span class="bg-slate-50 px-2 py-0.5 rounded-lg border border-slate-100 font-medium">🇵🇰 Urdu</span>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div class="pt-4 flex items-center justify-between text-xs text-slate-500" style="border-top:1px solid #f1f5f9;">
                    @if($item->duration_minutes)
                        <span class="flex items-center gap-1.5 font-medium">
                            <svg class="w-3.5 h-3.5 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $item->duration_minutes }} min read
                        </span>
                    @else
                        <span class="font-medium">Free Lesson</span>
                    @endif

                    <a href="{{ route('learn.show', $item->slug) }}" wire:navigate
                        class="font-bold text-slate-700 group-hover:text-[#28a04a] inline-flex items-center gap-1 transition-colors">
                        Read Lesson
                        <svg class="w-3.5 h-3.5 text-[#39E554] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl p-12 text-center border space-y-3 fp-animate-in"
                style="background:#fff; border-color:rgba(226,232,240,0.8);">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl"
                    style="background:rgba(57,229,84,0.1);">📖</div>
                <h3 class="text-lg font-bold text-slate-900">No Articles Found</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    {{ $onlyBookmarks ? 'You haven\'t saved any articles yet. Click the bookmark icon on any article to save it here!' : 'No content matches your filters. Try resetting or adjusting your search.' }}
                </p>
                <div class="pt-2">
                    <button type="button" wire:click="resetFilters"
                        class="px-5 py-2.5 text-slate-950 text-xs font-bold rounded-xl transition-all shadow"
                        style="background:linear-gradient(135deg,#39E554,#28a04a);">
                        View All Articles
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $items->links() }}
    </div>

</div>