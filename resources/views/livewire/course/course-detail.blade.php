<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-8">
    <!-- Breadcrumbs -->
    <div class="fp-animate-in">
        <a
            href="{{ route('courses.index') }}"
            wire:navigate
            class="inline-flex items-center gap-1 text-sm font-semibold text-finpulse-navy hover:text-[#39E554] transition-colors group"
        >
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Back to Courses</span>
        </a>
    </div>

    <!-- Course Overview Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6 fp-animate-in">
        @php
            $skillBadgeClass = match($course->skill_level?->value ?? $course->skill_level) {
                'beginner' => 'bg-amber-100 text-amber-900 border-amber-300',
                'intermediate' => 'bg-blue-100 text-finpulse-navy border-blue-200',
                'advanced' => 'bg-gray-100 text-gray-900 border-gray-300',
                default => 'bg-gray-100 text-gray-800 border-gray-200',
            };
        @endphp

        <div class="space-y-4">
            <!-- Badges -->
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $skillBadgeClass }}">
                    {{ ucfirst($course->skill_level?->value ?? $course->skill_level ?? 'General') }}
                </span>

                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-finpulse-cream text-finpulse-navy border border-amber-200 uppercase tracking-wider">
                    {{ ($course->language?->value ?? $course->language) === 'en' ? 'English' : 'Urdu' }}
                </span>

                @if(!$isFreeTier)
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-500 text-white uppercase tracking-wider shadow-sm">
                        {{ strtoupper($course->tier?->value ?? $course->tier) }} ACCESS
                    </span>
                @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                        FREE
                    </span>
                @endif
            </div>

            <!-- Title & Description -->
            <h1 class="text-2xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight leading-tight">
                {{ $course->title }}
            </h1>

            <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-4xl">
                {{ $course->description }}
            </p>

            <!-- Metadata Row -->
            <div class="flex items-center gap-6 text-xs sm:text-sm text-finpulse-gray border-y border-gray-100 py-3">
                <span class="flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    {{ $totalChapters }} {{ Str::plural('Chapter', $totalChapters) }}
                </span>

                @php
                    $totalMinutes = $chapters->sum(fn ($ch) => $ch->contentItem?->duration_minutes ?? 0);
                @endphp
                @if($totalMinutes > 0)
                    <span class="flex items-center gap-1.5 font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ~{{ $totalMinutes }} mins total
                    </span>
                @endif

                @if($course->author)
                    <span class="flex items-center gap-1.5 text-gray-500">
                        Instructor: <strong class="text-finpulse-navy">{{ $course->author->name }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!-- Locked Teaser Paywall Stub (when not accessible) -->
        @if(!$canAccess)
            <div class="bg-gray-900 text-white rounded-xl p-8 text-center border border-gray-800 space-y-4 my-4 shadow-md fp-animate-in">
                <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto fp-float">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-white">
                    This course is locked
                </h3>

                <p class="text-sm text-gray-300 max-w-md mx-auto leading-relaxed">
                    @if(($course->tier?->value ?? $course->tier) === 'registered')
                        This course requires a registered account. Please log in or create a free FinPulse account to unlock all chapters.
                    @else
                        This curriculum is part of our premium financial masterclasses. Upgrade your subscription to unlock all premium courses.
                    @endif
                </p>

                <div class="pt-3 flex items-center justify-center gap-3">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#39E554] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
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
                            href="{{ route('pricing') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#39E554] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                        >
                            Upgrade Membership
                        </a>
                    @endguest
                </div>
            </div>
        @endif

        <!-- Progress & Action Bar (for free tier or viewable) -->
        @if($canAccess && $totalChapters > 0)
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex-1 w-full sm:w-auto space-y-2">
                    <div class="flex items-center justify-between text-xs font-semibold text-finpulse-navy">
                        <span>Course Progress</span>
                        @if(auth()->check())
                            <span class="text-[#39E554]">{{ $completedCount }} of {{ $totalChapters }} completed ({{ $progressPercent }}%)</span>
                        @else
                            <span class="text-gray-500 font-normal">Log in to track your progress</span>
                        @endif
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-finpulse-navy to-[#39E554] h-2.5 rounded-full transition-all duration-500"
                            style="width: {{ min(100, $progressPercent) }}%"
                        ></div>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto flex-wrap sm:flex-nowrap">
                    @if($certificate)
                        <div class="shrink-0 w-full sm:w-auto">
                            <a
                                href="{{ route('certificates.download', $certificate->id) }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg font-bold text-sm bg-emerald-700 text-white shadow-sm hover:bg-emerald-800 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5"
                            >
                                <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Download Certificate</span>
                            </a>
                        </div>
                    @endif

                    @if($targetChapter)
                        <div class="shrink-0 w-full sm:w-auto">
                            <a
                                href="{{ route('courses.chapter', [$course->slug, $targetChapter->id]) }}"
                                wire:navigate
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-bold text-sm shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5
                                    {{ $actionType === 'review' ? 'bg-finpulse-navy text-white hover:bg-slate-800' : 'bg-[#39E554] hover:bg-amber-400 text-finpulse-navy' }}"
                            >
                                @if($actionType === 'review')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span>Review Course</span>
                                @elseif($actionType === 'continue')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    <span>Continue</span>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Start Course</span>
                                @endif
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Chapter List Section -->
    <div class="space-y-4 fp-animate-in">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-finpulse-navy tracking-tight">Course Syllabus & Chapters</h2>
            <span class="text-xs font-semibold text-finpulse-gray uppercase tracking-wider">{{ $totalChapters }} {{ Str::plural('Lesson', $totalChapters) }}</span>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-100 overflow-hidden">
            @forelse($chapters as $chapter)
                @php
                    $isDone = in_array($chapter->id, $completedChapterIds);
                    $canOpen = $canAccess;
                @endphp
                <div class="p-4 sm:p-5 flex items-center justify-between gap-4 transition-colors duration-150 {{ $isDone ? 'bg-emerald-50/40 hover:bg-emerald-50/70' : 'hover:bg-gray-50' }}">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <!-- Status Circle / Checkmark -->
                        <div class="shrink-0">
                            @if($isDone)
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center border border-emerald-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-bold border border-gray-300">
                                    {{ $chapter->order ?: $loop->iteration }}
                                </div>
                            @endif
                        </div>

                        <!-- Chapter Title & Info -->
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-semibold text-finpulse-navy truncate">
                                @if($canOpen)
                                    <a
                                        href="{{ route('courses.chapter', [$course->slug, $chapter->id]) }}"
                                        wire:navigate
                                        class="hover:text-[#39E554] transition-colors"
                                    >
                                        {{ $chapter->title }}
                                    </a>
                                @else
                                    <span class="text-gray-700">{{ $chapter->title }}</span>
                                @endif
                            </h3>

                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-0.5">
                                @if($chapter->contentItem)
                                    <span class="flex items-center gap-1">
                                        @if(($chapter->contentItem->type?->value ?? $chapter->contentItem->type) === 'video')
                                            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                            Video Lesson
                                        @else
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                            Article
                                        @endif
                                    </span>

                                    @if($chapter->contentItem->duration_minutes)
                                        <span>&bull;</span>
                                        <span>{{ $chapter->contentItem->duration_minutes }} min read</span>
                                    @endif
                                @endif

                                @if($isDone)
                                    <span>&bull;</span>
                                    <span class="text-emerald-700 font-medium">Completed</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="shrink-0">
                        @if($canOpen)
                            <a
                                href="{{ route('courses.chapter', [$course->slug, $chapter->id]) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all
                                    {{ $isDone ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-finpulse-navy text-white hover:bg-[#39E554] hover:bg-[#28a04a]' }}"
                            >
                                <span>{{ $isDone ? 'Review' : 'Start' }}</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Locked
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p class="text-sm">Chapters are being prepared for this course. Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
