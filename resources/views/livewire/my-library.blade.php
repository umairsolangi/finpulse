<div class="min-h-screen bg-[#F2F6F3] dark:!bg-[#0c1a14]">
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6" style="font-family:'Plus Jakarta Sans',sans-serif;">

        {{-- Header --}}
        <div class="fp-animate-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                        📚 My Library
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Your saved articles, videos, and learning content.</p>
                </div>
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-950 transition-all hover:-translate-y-0.5 shadow-md"
                    style="background:linear-gradient(135deg,#39E554,#32d44b);box-shadow:0 6px 20px rgba(57,229,84,0.35);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Discover More
                </a>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="flex flex-col sm:flex-row gap-3 fp-animate-in">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search your saved content..."
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#39E554] focus:ring-2 focus:ring-[#39E554]/20 transition-all"
                    id="library-search">
            </div>
            <select wire:model.live="filterType"
                class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-700 dark:text-slate-200 focus:border-[#39E554] focus:ring-2 focus:ring-[#39E554]/20 transition-all"
                id="library-filter">
                <option value="">All Types</option>
                <option value="article">📝 Articles</option>
                <option value="video">🎬 Videos</option>
                <option value="tip">💡 Tips</option>
            </select>
        </div>

        {{-- Bookmarks Grid --}}
        @if($bookmarks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 fp-stagger-grid">
                @foreach($bookmarks as $bookmark)
                    <div class="bg-white dark:!bg-[#132a1f] rounded-2xl border border-slate-200/80 dark:!border-emerald-900/30 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-[#39E554]/40 transition-all duration-300 group overflow-hidden fp-tilt-card"
                         wire:key="bookmark-{{ $bookmark->id }}">
                        {{-- Type Badge --}}
                        @php
                            $itemType = $bookmark->contentItem->type instanceof \BackedEnum ? $bookmark->contentItem->type->value : (string) $bookmark->contentItem->type;
                            $skillLevel = $bookmark->contentItem->skill_level instanceof \BackedEnum ? $bookmark->contentItem->skill_level->value : (string) $bookmark->contentItem->skill_level;
                        @endphp
                        <div class="p-5 pb-0">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full
                                    {{ $itemType === 'video' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : ($itemType === 'tip' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300') }}">
                                    @if($itemType === 'video')
                                        🎬
                                    @elseif($itemType === 'tip')
                                        💡
                                    @else
                                        📝
                                    @endif
                                    {{ ucfirst($itemType) }}
                                </span>
                                <button wire:click="removeBookmark({{ $bookmark->id }})"
                                    wire:confirm="Remove this from your library?"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all opacity-0 group-hover:opacity-100"
                                    title="Remove bookmark"
                                    id="remove-bookmark-{{ $bookmark->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Content --}}
                        <a href="{{ route('learn.show', $bookmark->contentItem->slug) }}" wire:navigate class="block px-5 pb-5">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-[#28a04a] transition-colors">
                                {{ $bookmark->contentItem->title }}
                            </h3>
                            @if($bookmark->contentItem->excerpt)
                                <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-3 leading-relaxed">
                                    {{ $bookmark->contentItem->excerpt }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if($skillLevel)
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                            {{ ucfirst($skillLevel) }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500">
                                    Saved {{ $bookmark->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $bookmarks->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center fp-animate-in">
                <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-6"
                    style="background:linear-gradient(135deg,rgba(57,229,84,0.15),rgba(40,160,74,0.1));border:1px solid rgba(57,229,84,0.2);">
                    <svg class="w-10 h-10 text-[#28a04a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">Your library is empty</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mb-6">
                    Start saving articles, videos, and tips by clicking the bookmark icon on any content.
                </p>
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-slate-950 transition-all hover:-translate-y-0.5"
                    style="background:linear-gradient(135deg,#39E554,#32d44b);box-shadow:0 6px 20px rgba(57,229,84,0.35);">
                    Start Exploring
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
