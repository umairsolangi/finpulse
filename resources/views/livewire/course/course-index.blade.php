<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto space-y-3 fp-animate-in">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">Financial Education Courses</h1>
        <p class="text-base sm:text-lg text-finpulse-gray">Structured, comprehensive learning paths designed to take you from market basics to advanced wealth building.</p>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 space-y-4 fp-animate-in">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Field -->
            <div>
                <label for="search" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Search Courses</label>
                <div class="relative">
                    <input
                        id="search"
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by title or topic..."
                        class="w-full rounded-lg border-gray-300 pl-9 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                    />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
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

            <!-- Tier Filter -->
            <div>
                <label for="tier" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">Access Tier</label>
                <select
                    id="tier"
                    wire:model.live="tier"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"
                >
                    <option value="all">All Tiers</option>
                    @foreach($tiers as $t)
                        <option value="{{ $t->value }}">{{ strtoupper($t->value) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($skillLevel !== 'all' || $language !== 'all' || $tier !== 'all' || $search !== '')
            <div class="flex justify-end pt-2 border-t border-gray-100">
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="text-xs font-semibold text-finpulse-navy hover:text-[#39E554] transition-colors"
                >
                    Reset Filters
                </button>
            </div>
        @endif
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($courses as $course)
            @php
                $skillBadgeClass = match($course->skill_level?->value ?? $course->skill_level) {
                    'beginner' => 'bg-amber-100 text-amber-900 border-amber-300',
                    'intermediate' => 'bg-blue-100 text-finpulse-navy border-blue-200',
                    'advanced' => 'bg-gray-100 text-gray-900 border-gray-300',
                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                };

                $isFreeTier = ($course->tier?->value ?? $course->tier) === 'free';
                $hasStarted = auth()->check() && ($course->completed_chapters_count ?? 0) > 0;
                $completedCount = $course->completed_chapters_count ?? 0;
                $totalChapters = $course->chapters_count ?? 0;
                $progressPercent = $totalChapters > 0 ? (int) round(($completedCount / $totalChapters) * 100) : 0;
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between group fp-card-hover space-y-4">
                <div class="space-y-3">
                    <!-- Badges Row -->
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $skillBadgeClass }}">
                            {{ ucfirst($course->skill_level?->value ?? $course->skill_level ?? 'General') }}
                        </span>

                        @if($course->restricted_to_batches)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-purple-600 text-white uppercase tracking-wider shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                COHORT ONLY
                            </span>
                        @elseif(!$isFreeTier)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-500 text-white uppercase tracking-wider shadow-sm">
                                {{ strtoupper($course->tier?->value ?? $course->tier) }} ACCESS
                            </span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                FREE
                            </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h2 class="text-lg font-bold text-finpulse-navy group-hover:text-[#39E554] transition-colors duration-200 line-clamp-2">
                        <a href="{{ route('courses.show', $course->slug) }}" wire:navigate>
                            {{ $course->title }}
                        </a>
                    </h2>

                    <!-- Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                        {{ Str::limit(strip_tags($course->description ?? 'Comprehensive structured course curriculum.'), 140) }}
                    </p>

                    <!-- Progress Indicator IF logged in and user has started the course -->
                    @if($hasStarted)
                        <div class="pt-2 space-y-1.5">
                            <div class="flex items-center justify-between text-xs font-medium text-finpulse-navy">
                                <span>{{ $completedCount }} of {{ $totalChapters }} {{ Str::plural('chapter', $totalChapters) }} complete</span>
                                <span class="font-bold text-[#39E554]">{{ $progressPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div
                                    class="bg-gradient-to-r from-finpulse-navy to-[#39E554] h-2 rounded-full transition-all duration-500"
                                    style="width: {{ min(100, $progressPercent) }}%"
                                ></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-finpulse-gray">
                    <span class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ $totalChapters }} {{ Str::plural('Chapter', $totalChapters) }}
                    </span>

                    <a
                        href="{{ route('courses.show', $course->slug) }}"
                        wire:navigate
                        class="font-semibold text-finpulse-navy group-hover:text-[#39E554] inline-flex items-center gap-1 transition-colors"
                    >
                        <span>{{ $hasStarted ? 'Continue' : 'View Course' }}</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl p-12 text-center border border-gray-200 space-y-3 fp-animate-in">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-finpulse-navy">No Courses Found</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto">No courses match your selected filter criteria. Try resetting filters or adjusting search terms.</p>
                @if($skillLevel !== 'all' || $language !== 'all' || $tier !== 'all' || $search !== '')
                    <div class="pt-2">
                        <button
                            type="button"
                            wire:click="resetFilters"
                            class="px-4 py-2 bg-finpulse-navy text-white text-xs font-semibold rounded-lg hover:bg-[#39E554] transition-all duration-300 hover:shadow-md"
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
        {{ $courses->links() }}
    </div>
</div>
