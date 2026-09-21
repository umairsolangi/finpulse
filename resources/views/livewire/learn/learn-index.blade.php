<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8 font-['DM_Sans',sans-serif]">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto space-y-3 fp-animate-in">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-[#00A86B] border border-emerald-200">
            <span>📚</span>
            <span>Education Hub • Retail Investor Library</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-[#0F172A] tracking-tight">Free Knowledge Library</h1>
        <p class="text-base text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Short 3–5 minute explainers, written market glossaries, and structured foundational guides designed to help you master the PSX, mutual funds, and smart wealth compounding.
        </p>
    </div>

    <!-- Filter & Library Tabs Bar -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-5 sm:p-6 space-y-5 fp-animate-in">
        
        <!-- Top Tabs: All vs My Saved Reading List -->
        <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <button type="button" wire:click="$set('onlyBookmarks', false)"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ ! $onlyBookmarks ? 'bg-[#0F172A] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    All Articles & Guides
                </button>

                <button type="button" wire:click="toggleSavedFilter"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $onlyBookmarks ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <span>⭐ Saved Reading List</span>
                    @if(count($bookmarkedIds) > 0)
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $onlyBookmarks ? 'bg-amber-600 text-white' : 'bg-slate-200 text-slate-700' }}">
                            {{ count($bookmarkedIds) }}
                        </span>
                    @endif
                </button>
            </div>

            @if(count($completedIds) > 0)
                <div class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 flex items-center gap-1.5">
                    <span>✓</span>
                    <span>You've completed <strong>{{ count($completedIds) }}</strong> {{ Str::plural('lesson', count($completedIds)) }}</span>
                </div>
            @endif
        </div>

        <!-- Filter Controls Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Field -->
            <div>
                <label for="search" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Search</label>
                <div class="relative">
                    <input id="search" type="text" wire:model.live.debounce.300ms="search" placeholder="Search topic or ticker..."
                        class="w-full rounded-xl border-slate-200 pl-9 text-xs sm:text-sm focus:border-[#00C48C] focus:ring-[#00C48C] transition-colors" />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Content Type Filter -->
            <div>
                <label for="type" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Format</label>
                <select id="type" wire:model.live="type"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#00C48C] focus:ring-[#00C48C] transition-colors">
                    <option value="all">All Formats</option>
                    @foreach($types as $t)
                        <option value="{{ $t->value }}">{{ str_replace('_', ' ', ucfirst($t->value)) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Skill Level Filter -->
            <div>
                <label for="skillLevel" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Skill Level</label>
                <select id="skillLevel" wire:model.live="skillLevel"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#00C48C] focus:ring-[#00C48C] transition-colors">
                    <option value="all">All Skill Levels</option>
                    @foreach($skillLevels as $level)
                        <option value="{{ $level->value }}">{{ ucfirst($level->value) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Language Filter -->
            <div>
                <label for="language" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Language</label>
                <select id="language" wire:model.live="language"
                    class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#00C48C] focus:ring-[#00C48C] transition-colors">
                    <option value="all">All Languages</option>
                    @foreach($languages as $lang)
                        <option value="{{ $lang->value }}">{{ $lang->value === 'en' ? 'English (with Urdu Mode)' : 'Urdu' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($type !== 'all' || $skillLevel !== 'all' || $language !== 'all' || $search !== '' || $onlyBookmarks)
            <div class="flex justify-end pt-2 border-t border-slate-100">
                <button type="button" wire:click="resetFilters"
                    class="text-xs font-bold text-[#00A86B] hover:underline transition-colors">
                    Reset All Filters
                </button>
            </div>
        @endif
    </div>

    <!-- Content Items Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($items as $item)
            @php
                $skillBadge = match ($item->skill_level?->value ?? $item->skill_level) {
                    'beginner' => ['bg' => 'bg-emerald-50 text-[#00A86B] border-emerald-200', 'label' => 'Beginner'],
                    'intermediate' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Intermediate'],
                    'advanced' => ['bg' => 'bg-purple-50 text-purple-700 border-purple-200', 'label' => 'Advanced'],
                    default => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => 'General'],
                };

                $isBookmarked = in_array($item->id, $bookmarkedIds);
                $isCompleted = in_array($item->id, $completedIds);
            @endphp

            <div class="bg-white rounded-2xl shadow-2xs border border-slate-200/90 p-6 flex flex-col justify-between group hover:border-[#00C48C]/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative space-y-4">
                
                <div class="space-y-3">
                    <!-- Badges Row -->
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border {{ $skillBadge['bg'] }}">
                                {{ $skillBadge['label'] }}
                            </span>

                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 uppercase tracking-wider">
                                {{ str_replace('_', ' ', ucfirst($item->type?->value ?? $item->type)) }}
                            </span>
                        </div>

                        <!-- Status badges (Saved / Completed) -->
                        <div class="flex items-center gap-1 text-xs">
                            @if($isBookmarked)
                                <span class="text-amber-500 font-black text-sm" title="Saved to your list">★</span>
                            @endif
                            @if($isCompleted)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[#008f62] font-bold text-[10px] flex items-center gap-0.5">
                                    ✓ Read
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-base sm:text-lg font-bold text-[#0F172A] group-hover:text-[#00A86B] transition-colors duration-200 line-clamp-2 leading-snug">
                        <a href="{{ route('learn.show', $item->slug) }}" wire:navigate>
                            {{ $item->title }}
                        </a>
                    </h2>

                    <!-- Body Snippet -->
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($item->body ?? 'Free financial educational content lesson.'), 140) }}
                    </p>

                    <!-- Features micro pill indicators -->
                    <div class="flex items-center gap-2 text-[10px] text-slate-400 pt-1">
                        @if($item->key_takeaways)
                            <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100">📌 Cheat Sheet</span>
                        @endif
                        @if($item->quiz_data)
                            <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100">🧠 Concept Quiz</span>
                        @endif
                        @if($item->urdu_body)
                            <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100">🇵🇰 Urdu Mode</span>
                        @endif
                    </div>
                </div>

                <!-- Meta Footer -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    @if($item->duration_minutes)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#00C48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $item->duration_minutes }} min read</span>
                        </span>
                    @else
                        <span>Free Lesson</span>
                    @endif

                    <a href="{{ route('learn.show', $item->slug) }}" wire:navigate
                        class="font-bold text-[#0F172A] group-hover:text-[#00A86B] inline-flex items-center gap-1 transition-colors">
                        <span>Read Lesson</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform text-[#00C48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200 space-y-3 fp-animate-in">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4 text-2xl">
                    📖
                </div>
                <h3 class="text-lg font-bold text-[#0F172A]">No Articles Found</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                    {{ $onlyBookmarks ? 'You have not saved any articles to your reading list yet. Click the bookmark icon on any article to save it here!' : 'No content items match your selected filter criteria. Try resetting filters or adjusting search terms.' }}
                </p>
                <div class="pt-2">
                    <button type="button" wire:click="resetFilters"
                        class="px-5 py-2.5 bg-[#0F172A] text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition-all shadow-xs">
                        View All Articles
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $items->links() }}
    </div>
</div>