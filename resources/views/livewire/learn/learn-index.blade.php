<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto space-y-3 fp-animate-in">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">Free Content Library</h1>
        <p class="text-base sm:text-lg text-finpulse-gray">Explore free financial education articles, video guides, and foundational tutorials designed to empower your financial journey.</p>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 space-y-4 fp-animate-in">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Field -->
            <div>
                <label for="search" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Search</label>
                <div class="relative">
                    <input
                        id="search"
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search title..."
                        class="w-full rounded-lg border-gray-300 pl-9 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                    />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Content Type Filter -->
            <div>
                <label for="type" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Type</label>
                <select
                    id="type"
                    wire:model.live="type"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                >
                    <option value="all">All Types</option>
                    @foreach($types as $t)
                        <option value="{{ $t->value }}">{{ str_replace('_', ' ', ucfirst($t->value)) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Skill Level Filter -->
            <div>
                <label for="skillLevel" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Skill Level</label>
                <select
                    id="skillLevel"
                    wire:model.live="skillLevel"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                >
                    <option value="all">All Skill Levels</option>
                    @foreach($skillLevels as $level)
                        <option value="{{ $level->value }}">{{ ucfirst($level->value) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Language Filter -->
            <div>
                <label for="language" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Language</label>
                <select
                    id="language"
                    wire:model.live="language"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                >
                    <option value="all">All Languages</option>
                    @foreach($languages as $lang)
                        <option value="{{ $lang->value }}">{{ $lang->value === 'en' ? 'English' : 'Urdu' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($type !== 'all' || $skillLevel !== 'all' || $language !== 'all' || $search !== '')
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="text-xs font-semibold text-finpulse-navy hover:text-[#C89B3C] transition-colors"
                >
                    Reset Filters
                </button>
            </div>
        @endif
    </div>

    <!-- Content Items Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($items as $item)
            @php
                $skillBadgeClass = match($item->skill_level?->value ?? $item->skill_level) {
                    'beginner' => 'bg-amber-100 text-amber-900 border-amber-300',
                    'intermediate' => 'bg-blue-100 text-finpulse-navy border-blue-200',
                    'advanced' => 'bg-gray-100 text-gray-900 border-gray-300',
                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                };
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between group fp-card-hover space-y-4">
                <div class="space-y-3">
                    <!-- Badges Row -->
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $skillBadgeClass }}">
                            {{ ucfirst($item->skill_level?->value ?? $item->skill_level ?? 'General') }}
                        </span>

                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-finpulse-cream text-finpulse-navy border border-amber-200 uppercase tracking-wider">
                            {{ str_replace('_', ' ', ucfirst($item->type?->value ?? $item->type)) }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-lg font-bold text-finpulse-navy group-hover:text-[#C89B3C] transition-colors duration-200 line-clamp-2">
                        <a href="{{ route('learn.show', $item->slug) }}" wire:navigate>
                            {{ $item->title }}
                        </a>
                    </h2>

                    <!-- Body Snippet -->
                    <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($item->body ?? 'Free financial educational content lesson.'), 140) }}
                    </p>
                </div>

                <!-- Meta Footer -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-finpulse-gray">
                    @if($item->duration_minutes)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $item->duration_minutes }} mins
                        </span>
                    @else
                        <span>Free Lesson</span>
                    @endif

                    <a
                        href="{{ route('learn.show', $item->slug) }}"
                        wire:navigate
                        class="font-semibold text-finpulse-navy group-hover:text-[#C89B3C] inline-flex items-center gap-1 transition-colors"
                    >
                        <span>View {{ $item->type?->value === 'video' ? 'Video' : 'Article' }}</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl p-12 text-center border border-gray-200 space-y-3 fp-animate-in">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-lg font-bold text-finpulse-navy">No Content Items Found</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto">No free content items match your selected filter criteria. Try resetting filters or adjusting search terms.</p>
                @if($type !== 'all' || $skillLevel !== 'all' || $language !== 'all' || $search !== '')
                    <div class="pt-2">
                        <button
                            type="button"
                            wire:click="resetFilters"
                            class="px-4 py-2 bg-finpulse-navy text-white text-xs font-semibold rounded-lg hover:bg-[#C89B3C] transition-all duration-300 hover:shadow-md"
                        >
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $items->links() }}
    </div>
</div>
