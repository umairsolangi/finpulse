<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6">
    <!-- Top Breadcrumb & Progress Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 pb-4 fp-animate-in">
        <div class="flex items-center gap-2 text-xs sm:text-sm text-finpulse-gray flex-wrap">
            <a href="{{ route('courses.index') }}" wire:navigate class="hover:text-[#C89B3C] font-semibold transition-colors">Courses</a>
            <span>/</span>
            <a href="{{ route('courses.show', $course->slug) }}" wire:navigate class="hover:text-[#C89B3C] font-semibold transition-colors truncate max-w-xs">{{ $course->title }}</a>
            <span>/</span>
            <span class="text-finpulse-navy font-bold">Chapter {{ $currentIndex }} of {{ $totalChapters }}</span>
        </div>

        <div class="flex items-center gap-3 self-end sm:self-auto">
            <a
                href="{{ route('courses.show', $course->slug) }}"
                wire:navigate
                class="inline-flex items-center gap-1 text-xs font-semibold text-finpulse-navy hover:text-[#C89B3C] transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>Course Syllabus</span>
            </a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-10 space-y-8 fp-animate-in">
        @if(!$isFreeTier)
            <!-- Locked Teaser State (when tier is not free) -->
            <div class="bg-gray-900 text-white rounded-xl p-8 text-center border border-gray-800 space-y-4 shadow-md fp-animate-in">
                <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto fp-float">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-white">
                    This chapter is locked
                </h3>

                <p class="text-sm text-gray-300 max-w-md mx-auto leading-relaxed">
                    @if(($course->tier?->value ?? $course->tier) === 'registered')
                        This chapter requires a registered account. Please log in or create a free FinPulse account to unlock full access.
                    @else
                        This lesson is part of our premium financial curriculum. Upgrade your subscription to Paid Subscriber to unlock all premium courses.
                    @endif
                </p>

                <div class="pt-3 flex items-center justify-center gap-3">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
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
                            href="{{ route('dashboard') }}"
                            wire:navigate
                            class="px-5 py-2.5 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                        >
                            Upgrade Membership
                        </a>
                    @endguest
                </div>
            </div>
        @else
            <!-- Free Tier Chapter Viewer -->
            <div class="space-y-6">
                <!-- Chapter Header -->
                <div class="border-b border-gray-100 pb-6 space-y-3">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#C89B3C] bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                            Chapter {{ $currentIndex }} of {{ $totalChapters }}
                        </span>

                        @if($isCompleted)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Completed
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-finpulse-navy tracking-tight leading-tight">
                        {{ $chapter->title }}
                    </h1>

                    @if($chapter->contentItem)
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="capitalize font-medium">
                                {{ str_replace('_', ' ', $chapter->contentItem->type?->value ?? $chapter->contentItem->type) }}
                            </span>
                            @if($chapter->contentItem->duration_minutes)
                                <span>&bull;</span>
                                <span>{{ $chapter->contentItem->duration_minutes }} minutes estimated</span>
                            @endif
                            @if($quiz)
                                <span>&bull;</span>
                                <span class="font-semibold text-amber-600">Includes Quiz</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Lesson Content (Article / Video) -->
                <div class="pt-2">
                    <x-content-renderer :item="$chapter->contentItem" />
                </div>

                <!-- Chapter Quiz Section (if chapter has quiz) -->
                @if($quiz)
                    <div id="chapter-quiz" class="mt-10 pt-8 border-t-2 border-dashed border-gray-200 space-y-6 fp-animate-in">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div>
                                <h3 class="text-xl font-bold text-finpulse-navy flex items-center gap-2">
                                    <span>Chapter Assessment Quiz</span>
                                    <span class="text-xs bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-full font-semibold border border-amber-300">
                                        Pass: 70%
                                    </span>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">Pass this quiz with 70% or higher to mark this chapter complete.</p>
                            </div>

                            @if($hasPassedQuiz)
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Quiz Passed
                                </span>
                            @endif
                        </div>

                        <!-- Attempt Result Alert -->
                        @if($latestAttempt && ($quizSubmitted || $latestAttempt->passed))
                            <div class="p-5 rounded-xl border {{ $latestAttempt->passed ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-rose-50 border-rose-300 text-rose-900' }} space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sm">
                                        {{ $latestAttempt->passed ? 'Assessment Passed!' : 'Assessment Not Passed' }}
                                    </span>
                                    <span class="text-lg font-black {{ $latestAttempt->passed ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $latestAttempt->score }}%
                                    </span>
                                </div>
                                <p class="text-xs leading-relaxed">
                                    @if($latestAttempt->passed)
                                        Great job! You scored {{ $latestAttempt->score }}% (pass threshold is 70%). This chapter has been officially marked as complete.
                                    @else
                                        You scored {{ $latestAttempt->score }}%. A minimum of 70% is required to pass and complete this chapter. Review the questions below and try again.
                                    @endif
                                </p>
                                @if(!$latestAttempt->passed || $quizSubmitted)
                                    <div class="pt-2">
                                        <button
                                            type="button"
                                            wire:click="retakeQuiz"
                                            class="px-4 py-2 bg-finpulse-navy text-white text-xs font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-sm"
                                        >
                                            Retake Quiz
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Questions List (All on One Page) -->
                        <div class="space-y-6">
                            @foreach($quiz->questions as $qIndex => $question)
                                <div class="bg-gray-50/70 rounded-xl p-5 border border-gray-200 space-y-4">
                                    <div class="flex items-start gap-3">
                                        <span class="w-6 h-6 rounded-full bg-finpulse-navy text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                            {{ $qIndex + 1 }}
                                        </span>
                                        <h4 class="text-sm sm:text-base font-bold text-finpulse-navy">
                                            {{ $question->question }}
                                        </h4>
                                    </div>

                                    <div class="space-y-2 pl-9">
                                        @foreach($question->options as $option)
                                            @php
                                                $isSelected = ($selectedAnswers[$question->id] ?? null) == $option->id;
                                                $showFeedback = $quizSubmitted;
                                                $isCorrect = $option->is_correct;
                                            @endphp

                                            <label class="flex items-center gap-3 p-3 rounded-lg border text-xs sm:text-sm cursor-pointer transition-colors
                                                @if($showFeedback)
                                                    @if($isCorrect)
                                                        bg-emerald-50 border-emerald-400 text-emerald-900 font-semibold
                                                    @elseif($isSelected && !$isCorrect)
                                                        bg-rose-50 border-rose-400 text-rose-900 font-semibold
                                                    @else
                                                        bg-white border-gray-200 text-gray-700 opacity-60
                                                    @endif
                                                @else
                                                    {{ $isSelected ? 'bg-amber-50 border-[#C89B3C] text-finpulse-navy font-semibold shadow-sm' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-100/60' }}
                                                @endif
                                            ">
                                                <input
                                                    type="radio"
                                                    name="question_{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    wire:model="selectedAnswers.{{ $question->id }}"
                                                    @disabled($quizSubmitted && $hasPassedQuiz)
                                                    class="text-[#C89B3C] focus:ring-finpulse-navy border-gray-300"
                                                />
                                                <span class="flex-1">{{ $option->option_text }}</span>

                                                @if($showFeedback)
                                                    @if($isCorrect)
                                                        <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">Correct</span>
                                                    @elseif($isSelected && !$isCorrect)
                                                        <span class="text-[11px] font-bold text-rose-700 bg-rose-100 px-2 py-0.5 rounded">Your answer</span>
                                                    @endif
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Quiz Submit Button -->
                        @if(!$quizSubmitted && (!$hasPassedQuiz || count($selectedAnswers) > 0))
                            <div class="pt-4 flex justify-end">
                                <button
                                    type="button"
                                    wire:click="submitQuiz"
                                    wire:loading.attr="disabled"
                                    class="px-6 py-3 rounded-lg font-bold text-sm bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                                >
                                    <span wire:loading.remove>Submit Quiz</span>
                                    <span wire:loading>Evaluating...</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Action & Mark as Complete Bar -->
                <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Action Button -->
                    <div>
                        @auth
                            @if($quiz && !$hasPassedQuiz)
                                <button
                                    type="button"
                                    wire:click="$set('showQuiz', true)"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-bold text-sm shadow-sm transition-all duration-300 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy hover:shadow-md hover:-translate-y-0.5"
                                >
                                    <svg class="w-4 h-4 text-finpulse-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <span>Take Chapter Quiz</span>
                                </button>
                            @else
                                <button
                                    type="button"
                                    wire:click="markAsComplete"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-bold text-sm shadow-sm transition-all duration-300
                                        {{ $isCompleted
                                            ? 'bg-emerald-100 text-emerald-800 border border-emerald-300 hover:bg-emerald-200'
                                            : 'bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy hover:shadow-md hover:-translate-y-0.5' }}"
                                >
                                    <svg class="w-4 h-4 {{ $isCompleted ? 'text-emerald-700' : 'text-finpulse-navy' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span wire:loading.remove>{{ $isCompleted ? 'Completed' : 'Mark as Complete' }}</span>
                                    <span wire:loading>Saving...</span>
                                </button>
                            @endif
                        @else
                            <a
                                href="{{ route('login') }}"
                                wire:navigate
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-bold text-sm bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"
                            >
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span>Log in to track progress</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Chapter Counter Indicator -->
                    <span class="text-xs font-semibold text-gray-400">
                        Lesson {{ $currentIndex }} of {{ $totalChapters }}
                    </span>
                </div>

                <!-- Navigation Controls: Prev / Next / Course Complete -->
                <div class="pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between gap-4">
                        {{-- Previous Chapter Button --}}
                        <div>
                            @if($prevChapter)
                                <a
                                    href="{{ route('courses.chapter', [$course->slug, $prevChapter->id]) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-finpulse-navy bg-gray-100 hover:bg-gray-200 transition-colors group"
                                >
                                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="hidden sm:inline">Previous Chapter</span>
                                    <span class="sm:hidden">Prev</span>
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-gray-300 bg-gray-50 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="hidden sm:inline">First Chapter</span>
                                    <span class="sm:hidden">First</span>
                                </span>
                            @endif
                        </div>

                        {{-- Next / Course Complete Action --}}
                        <div>
                            @if($nextChapter)
                                <a
                                    href="{{ route('courses.chapter', [$course->slug, $nextChapter->id]) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-bold text-white bg-finpulse-navy hover:bg-[#C89B3C] hover:text-finpulse-navy transition-all duration-300 group shadow-sm hover:shadow-md"
                                >
                                    <span class="hidden sm:inline">Next Chapter</span>
                                    <span class="sm:hidden">Next</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @elseif($isLastChapter)
                                {{-- Course Complete UI State --}}
                                <a
                                    href="{{ route('courses.show', $course->slug) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 transition-colors shadow-sm"
                                >
                                    <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Course Complete</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($isLastChapter)
                        {{-- Celebratory Banner at the end of the course --}}
                        <div class="mt-6 bg-gradient-to-r from-emerald-50 via-teal-50 to-amber-50 border border-emerald-200 rounded-xl p-6 text-center space-y-2">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-finpulse-navy">Congratulations! You've reached the end of this course.</h3>
                            <p class="text-xs text-gray-600 max-w-md mx-auto">You have reviewed all chapters in this curriculum. Head back to the course overview to review lessons anytime.</p>
                            <div class="pt-2">
                                <a
                                    href="{{ route('courses.show', $course->slug) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-900 underline"
                                >
                                    <span>Return to Course Overview</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Chapter Drawer / Syllabus Accordion -->
    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden fp-animate-in">
        <button
            @click="open = !open"
            type="button"
            class="w-full p-4 sm:p-5 flex items-center justify-between text-left hover:bg-gray-50 transition-colors"
        >
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#C89B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="text-sm font-bold text-finpulse-navy">Jump to Another Chapter ({{ $totalChapters }} Lessons)</span>
            </div>
            <svg
                class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-cloak class="border-t border-gray-100 divide-y divide-gray-100 max-h-80 overflow-y-auto">
            @foreach($chapters as $ch)
                @php
                    $isChDone = in_array($ch->id, $completedChapterIds);
                    $isCurrent = $ch->id === $chapter->id;
                @endphp
                <a
                    href="{{ route('courses.chapter', [$course->slug, $ch->id]) }}"
                    wire:navigate
                    class="p-3.5 sm:px-6 flex items-center justify-between gap-3 text-xs sm:text-sm transition-colors
                        {{ $isCurrent ? 'bg-amber-50/80 font-bold text-finpulse-navy border-l-4 border-[#C89B3C]' : 'hover:bg-gray-50 text-gray-700' }}"
                >
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-6 text-center text-xs font-semibold text-gray-400">#{{ $ch->order ?: $loop->iteration }}</span>
                        <span class="truncate">{{ $ch->title }}</span>
                    </div>

                    <div class="shrink-0 flex items-center gap-2">
                        @if($isChDone)
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                        @if($isCurrent)
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#C89B3C] bg-amber-100 px-2 py-0.5 rounded">Now</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
