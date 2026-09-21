<section id="our-courses" class="py-24 relative overflow-hidden bg-[#F8F9FA] text-[#0F172A] font-['DM_Sans',sans-serif]">
    <style>
        #our-courses .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        #our-courses .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
    </style>

    <!-- Subtle Grid Background Overlay -->
    <div class="absolute inset-0 pointer-events-none opacity-40 z-0" aria-hidden="true"
        style="background-image: linear-gradient(rgba(100, 116, 139, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.08) 1px, transparent 1px); background-size: 80px 80px;">
    </div>

    <!-- Soft Ambient Glows -->
    <div class="absolute top-1/4 -left-48 w-96 h-96 bg-[#00C48C]/10 rounded-full blur-[120px] pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-1/4 -right-48 w-96 h-96 bg-[#00A86B]/10 rounded-full blur-[120px] pointer-events-none" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Heading -->
        <div class="text-center max-w-3xl mx-auto mb-10 reveal-item">
            
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#061A14] tracking-tight">
                Our Courses
            </h2>
            <div class="w-16 h-1 bg-[#00C48C] rounded-full mx-auto mt-4"></div>
            <p class="mt-4 text-base text-slate-600 max-w-2xl mx-auto">
                Explore expert-led investment tracks tailored for Pakistan capital markets, from fundamental valuation to technical strategies.
            </p>
        </div>

        <!-- Filter Tabs (Horizontally scrollable on mobile, no scrollbar) -->
        <div class="flex items-center justify-start md:justify-center gap-6 sm:gap-8 overflow-x-auto no-scrollbar border-b border-slate-200 mb-10 px-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- "New" Tab -->
            <button
                type="button"
                wire:click="setTab('new')"
                class="relative pb-3 text-sm sm:text-base font-medium whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'new' ? 'text-[#061A14] font-bold' : 'text-slate-500 hover:text-[#061A14]' }}">
                New
                @if($activeTab === 'new')
                    <span class="absolute bottom-0 left-0 right-0 h-[2.5px] bg-[#00C48C] rounded-full shadow-[0_0_8px_rgba(0,196,140,0.4)]"></span>
                @endif
            </button>

            <!-- "Popular" Tab -->
            <button
                type="button"
                wire:click="setTab('popular')"
                class="relative pb-3 text-sm sm:text-base font-medium whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'popular' ? 'text-[#061A14] font-bold' : 'text-slate-500 hover:text-[#061A14]' }}">
                Popular
                @if($activeTab === 'popular')
                    <span class="absolute bottom-0 left-0 right-0 h-[2.5px] bg-[#00C48C] rounded-full shadow-[0_0_8px_rgba(0,196,140,0.4)]"></span>
                @endif
            </button>

            <!-- Distinct Topic Tabs with Courses -->
            @foreach($topics as $topic)
                <button
                    type="button"
                    wire:click="setTab('{{ $topic->value }}')"
                    class="relative pb-3 text-sm sm:text-base font-medium whitespace-nowrap transition-colors duration-200 {{ $activeTab === $topic->value ? 'text-[#061A14] font-bold' : 'text-slate-500 hover:text-[#061A14]' }}">
                    {{ $topic->label() }}
                    @if($activeTab === $topic->value)
                        <span class="absolute bottom-0 left-0 right-0 h-[2.5px] bg-[#00C48C] rounded-full shadow-[0_0_8px_rgba(0,196,140,0.4)]"></span>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Carousel Container with Alpine.js -->
        <div
            x-data="{
                canScrollLeft: false,
                canScrollRight: true,
                updateScrollState() {
                    const el = this.$refs.carousel;
                    if (!el) return;
                    this.canScrollLeft = el.scrollLeft > 20;
                    this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 20);
                },
                scrollNext() {
                    this.$refs.carousel.scrollBy({ left: 340, behavior: 'smooth' });
                },
                scrollPrev() {
                    this.$refs.carousel.scrollBy({ left: -340, behavior: 'smooth' });
                }
            }"
            x-init="$nextTick(() => updateScrollState())"
            class="relative group">

            <!-- Desktop Arrow Navigation Buttons -->
            <!-- Left Arrow Button -->
            <button
                type="button"
                x-show="canScrollLeft"
                x-cloak
                @click="scrollPrev()"
                aria-label="Previous courses"
                class="hidden md:flex absolute -left-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white hover:bg-[#00C48C] text-slate-700 hover:text-white border border-slate-200 shadow-xl items-center justify-center backdrop-blur-md transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow Button -->
            <button
                type="button"
                x-show="canScrollRight"
                @click="scrollNext()"
                aria-label="Next courses"
                class="hidden md:flex absolute -right-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white hover:bg-[#00C48C] text-slate-700 hover:text-white border border-slate-200 shadow-xl items-center justify-center backdrop-blur-md transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Horizontally Scrollable Carousel Track -->
            <div
                x-ref="carousel"
                @scroll.passive="updateScrollState()"
                class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-6 pt-2 scroll-smooth no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                @forelse($courses as $index => $course)
                    @php
                        // Cycle through brand tones tailored to theme
                        $tones = [
                            'bg-gradient-to-br from-[#061A14] via-[#0A2E23] to-[#00C48C]',
                            'bg-gradient-to-br from-[#0B231B] via-[#124233] to-[#00A86B]',
                            'bg-gradient-to-br from-[#04120E] via-[#0D382B] to-[#059669]',
                            'bg-gradient-to-br from-[#07241A] via-[#0E4534] to-[#10B981]',
                        ];
                        $tone = $tones[$index % count($tones)];

                        $authorName = $course->author?->name ?? 'FinPulse Instructor';
                        $initials = collect(explode(' ', $authorName))
                            ->filter()
                            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                            ->take(2)
                            ->implode('');
                        if (empty($initials)) {
                            $initials = 'FP';
                        }
                    @endphp

                    <div
                        wire:key="course-{{ $course->id }}"
                        class="tilt-card snap-start shrink-0 w-[82vw] max-w-[310px] sm:w-[310px] rounded-2xl overflow-hidden bg-white border border-slate-200/90 shadow-[0_10px_25px_rgba(15,23,42,0.06)] hover:border-[#00C48C]/50 hover:shadow-[0_18px_38px_rgba(0,196,140,0.18)] transition-all duration-300 flex flex-col justify-between group">
                        
                        <!-- Top Banner -->
                        <div class="relative h-44 p-4 flex flex-col justify-between overflow-hidden {{ $tone }}">
                            <!-- Subtle decorative circle overlay -->
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/15 rounded-full blur-xl pointer-events-none" aria-hidden="true"></div>
                            
                            <!-- Top line badges -->
                            <div class="flex items-center justify-between gap-2 relative z-10">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider text-white bg-black/30 backdrop-blur-md border border-white/20">
                                    COURSE
                                </span>

                                @if($course->tier->value !== 'free')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold text-white bg-[#00C48C] border border-white/30 shadow-sm backdrop-blur-md">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
                                        </svg>
                                        Included With
                                    </span>
                                @endif
                            </div>

                            <!-- Banner Title & Instructor Info -->
                            <div class="relative z-10 flex items-end justify-between gap-3 mt-auto">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-white leading-snug line-clamp-2 drop-shadow-sm mb-1">
                                        {{ $course->title }}
                                    </h4>
                                    <p class="text-[11px] font-medium text-white/85 truncate tracking-wide">
                                        — {{ strtoupper($authorName) }}
                                    </p>
                                </div>

                                <!-- Instructor Avatar / Initials Placeholder -->
                                <div class="shrink-0">
                                    @if(!empty($course->author?->avatar_url))
                                        <img src="{{ $course->author->avatar_url }}" alt="{{ $authorName }}" class="w-11 h-11 rounded-full border-2 border-white/40 object-cover shadow-md">
                                    @else
                                        <div class="w-11 h-11 rounded-full bg-white/25 border-2 border-white/40 backdrop-blur-md flex items-center justify-center text-white font-extrabold text-xs tracking-wider shadow-md">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Body (Light Theme) -->
                        <div class="p-5 flex-1 flex flex-col justify-between bg-white">
                            <div>
                                <!-- Price / Subscription Indicator -->
                                <div class="mb-2">
                                    @if($course->tier->value === 'free')
                                        <span class="text-sm font-bold text-[#00A86B]">Free</span>
                                    @else
                                        <span class="text-xs font-semibold text-[#00A86B] bg-[#E6F9F2] px-2.5 py-1 rounded-md border border-[#00C48C]/20">
                                            Included with Subscription
                                        </span>
                                    @endif
                                </div>

                                <!-- Course Title Link -->
                                <h3 class="text-sm font-bold text-[#061A14] group-hover:text-[#00C48C] transition-colors line-clamp-1 mt-2">
                                    <a href="{{ route('courses.show', $course->slug) }}" class="hover:underline focus:outline-none">
                                        {{ $course->title }}
                                    </a>
                                </h3>

                                <!-- Description (truncated) -->
                                <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                    {{ $course->description }}
                                </p>
                            </div>

                            <!-- Bottom Row: Metadata & Enrolled Count -->
                            <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="text-[11px] font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                    {{ $course->skill_level ? ucfirst($course->skill_level->value) : 'All Levels' }}
                                </span>

                                <!-- Enrollment Count (ONLY shown if > 0) -->
                                @if($course->progress_count > 0)
                                    <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-[#00C48C]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        {{ $course->progress_count >= 1000 ? number_format($course->progress_count / 1000, 1) . 'K' : $course->progress_count }} Enrolled
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="w-full py-12 text-center text-slate-500">
                        <p class="text-sm">No courses currently available under this topic.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- View All Courses Action -->
        <div class="text-center mt-12">
            <a
                href="{{ route('courses.index') }}"
                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-semibold text-[#061A14] bg-[#00C48C] hover:bg-[#00D084] shadow-[0_4px_20px_rgba(0,196,140,0.3)] transition-all duration-200 hover:scale-105 active:scale-95">
                <span>Browse All Courses</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
