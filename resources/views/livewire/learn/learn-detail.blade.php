<div x-data="{
        scrollPercent: 0,
        updateScroll() {
            const h = document.documentElement.scrollHeight - window.innerHeight;
            this.scrollPercent = h > 0 ? Math.min(100, Math.max(0, (window.scrollY / h) * 100)) : 0;
        }
    }" @scroll.window="updateScroll()" class="min-h-screen bg-[#F8FAFC] py-8 px-4 sm:px-6 lg:px-8 font-['DM_Sans',sans-serif]">

    <!-- Top Reading Progress Indicator -->
    <div class="fixed top-0 left-0 right-0 h-1 bg-slate-200 z-50">
        <div class="h-full bg-gradient-to-r from-[#00C48C] to-[#00A86B] transition-all duration-150"
            :style="`width: ${scrollPercent}%`"></div>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Top Navigation & Action Controls Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white px-5 py-3.5 rounded-2xl border border-slate-200/80 shadow-xs">
            <a href="{{ route('learn.index') }}" wire:navigate
                class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-700 hover:text-[#00A86B] transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform text-[#00C48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Library</span>
            </a>

            <!-- Action Buttons: Language Switcher, Bookmark, Mark Read -->
            <div class="flex items-center gap-2.5 flex-wrap">
                <!-- Language Toggle Button -->
                @if($item->urdu_body)
                    <button type="button" wire:click="toggleLanguage"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 border shadow-2xs {{ $languageMode === 'ur' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-50 text-[#008f62] border-emerald-200 hover:bg-emerald-100' }}">
                        <span>{{ $languageMode === 'ur' ? '🇵🇰 Roman Urdu Mode' : '🇬🇧 English' }}</span>
                        <span class="text-[10px] opacity-75">({{ $languageMode === 'ur' ? 'Switch to English' : 'اردو خلاصہ' }})</span>
                    </button>
                @endif

                <!-- Bookmark Button -->
                <button type="button" wire:click="toggleBookmark"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 border shadow-2xs {{ $isBookmarked ? 'bg-amber-50 text-amber-700 border-amber-300' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}"
                    title="{{ $isBookmarked ? 'Remove from saved' : 'Save for later' }}">
                    <svg class="w-4 h-4 {{ $isBookmarked ? 'text-amber-500 fill-current' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <span>{{ $isBookmarked ? 'Saved' : 'Save' }}</span>
                </button>

                <!-- Mark as Completed Button -->
                <button type="button" wire:click="markAsCompleted"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 shadow-xs {{ $isCompleted ? 'bg-emerald-100 text-[#008f62] border border-emerald-300' : 'bg-[#00C48C] hover:bg-[#00A86B] text-slate-950 hover:text-white' }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4 text-[#00A86B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Completed (+3 XP)</span>
                    @else
                        <span>Mark as Read (+3 XP)</span>
                    @endif
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('bookmark_message'))
            <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs font-semibold flex items-center justify-between">
                <span>{{ session('bookmark_message') }}</span>
                <button type="button" @click="$el.parentElement.remove()" class="text-amber-500 hover:text-amber-700">&times;</button>
            </div>
        @endif

        @if(session()->has('completed_message'))
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-[#008f62] rounded-xl text-xs font-bold flex items-center justify-between shadow-xs">
                <span>{{ session('completed_message') }}</span>
                <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        <!-- Main Article Container Card -->
        <article class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-10 space-y-8">
            <!-- Article Header & Meta -->
            @php
                $skillBadge = match($item->skill_level?->value ?? $item->skill_level) {
                    'beginner' => ['bg' => 'bg-emerald-50 text-[#00A86B] border-emerald-200', 'label' => 'Beginner Friendly'],
                    'intermediate' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Intermediate PSX'],
                    'advanced' => ['bg' => 'bg-purple-50 text-purple-700 border-purple-200', 'label' => 'Advanced Valuation'],
                    default => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => 'General Financial Literacy'],
                };

                $isFreeTier = ($item->tier?->value ?? $item->tier) === 'free';
                $isRegistered = ($item->tier?->value ?? $item->tier) === 'registered';
                $canAccess = $isFreeTier || (auth()->check() && ($isRegistered || auth()->user()->hasPaidAccess()));
            @endphp

            <header class="space-y-4 border-b border-slate-100 pb-6">
                <!-- Badges Row -->
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $skillBadge['bg'] }}">
                        {{ $skillBadge['label'] }}
                    </span>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wider">
                        {{ str_replace('_', ' ', ucfirst($item->type?->value ?? $item->type)) }}
                    </span>

                    @if($isCompleted)
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-500 text-white shadow-xs flex items-center gap-1">
                            ✓ Read
                        </span>
                    @endif
                </div>

                <!-- Main Title -->
                <h1 class="text-2xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight leading-tight">
                    {{ $item->title }}
                </h1>

                <!-- Meta Row: Read Time, Published Date, Author -->
                <div class="flex items-center gap-5 text-xs text-slate-500 font-medium flex-wrap pt-1">
                    @if($item->duration_minutes)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#00C48C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $item->duration_minutes }} min read</span>
                        </span>
                    @endif

                    @if($item->published_at)
                        <span>Updated {{ $item->published_at->format('M d, Y') }}</span>
                    @endif

                    <span class="text-slate-400">•</span>
                    <span class="text-slate-700 font-semibold">FinPulse Research Team</span>
                </div>
            </header>

            <!-- Access Control Gating -->
            @if(!$canAccess)
                <!-- Locked Paywall Teaser -->
                <div class="bg-gradient-to-br from-[#061A14] to-[#0F172A] text-white rounded-2xl p-8 text-center border border-[#00C48C]/30 space-y-4 shadow-xl">
                    <div class="w-14 h-14 rounded-2xl bg-[#00C48C]/20 text-[#00C48C] flex items-center justify-center mx-auto">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-white">This content is locked</h3>
                    <p class="text-sm text-emerald-100/70 max-w-md mx-auto leading-relaxed">
                        @if(($item->tier?->value ?? $item->tier) === 'registered')
                            Create a free FinPulse account to unlock this guide and save it to your personalized learning dashboard.
                        @else
                            This deep-dive valuation guide is part of the FinPulse Paid Subscriber tier. Upgrade to access institutional models and live webinar labs.
                        @endif
                    </p>

                    <div class="pt-2 flex items-center justify-center gap-3">
                        @guest
                            <a href="{{ route('login') }}" wire:navigate
                                class="px-6 py-2.5 bg-[#00C48C] hover:bg-[#00D084] text-slate-950 font-bold text-sm rounded-xl transition-all shadow-md">
                                Log in to unlock
                            </a>
                            <a href="{{ route('register') }}" wire:navigate
                                class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-xl border border-white/20 transition-all">
                                Create Free Account
                            </a>
                        @else
                            <a href="{{ route('pricing') }}" wire:navigate
                                class="px-6 py-2.5 bg-[#00C48C] hover:bg-[#00D084] text-slate-950 font-bold text-sm rounded-xl transition-all shadow-md">
                                Upgrade to Paid Tier
                            </a>
                        @endguest
                    </div>
                </div>
            @else
                <!-- Full Content View -->

                <!-- Key Takeaways (TL;DR) Card -->
                @if($item->key_takeaways && count($item->key_takeaways) > 0)
                    <div class="bg-gradient-to-br from-emerald-50 via-teal-50/40 to-white border border-[#00C48C]/30 rounded-2xl p-5 sm:p-6 shadow-2xs">
                        <div class="flex items-center gap-2.5 mb-3 text-xs font-black uppercase tracking-wider text-[#00A86B]">
                            <span>📌</span>
                            <span>Key Takeaways (Quick Cheat Sheet)</span>
                        </div>
                        <ul class="space-y-2.5">
                            @foreach($item->key_takeaways as $takeaway)
                                <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700 leading-relaxed">
                                    <span class="w-4 h-4 rounded-full bg-[#00C48C]/20 text-[#00A86B] flex items-center justify-center shrink-0 mt-0.5 font-black text-[10px]">
                                        ✓
                                    </span>
                                    <span>{{ $takeaway }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Bilingual Switch Banner -->
                @if($languageMode === 'ur' && $item->urdu_body)
                    <div class="p-3.5 bg-emerald-600 text-white rounded-xl text-xs font-semibold flex items-center justify-between shadow-xs">
                        <div class="flex items-center gap-2">
                            <span>🇵🇰</span>
                            <span>Aap Roman Urdu Mode mein parh rahay hain. (Simple & practical Urdu translation).</span>
                        </div>
                        <button type="button" wire:click="toggleLanguage" class="underline text-emerald-100 hover:text-white text-xs">
                            Switch back to English
                        </button>
                    </div>
                @endif

                <!-- Body Content -->
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                    @if($languageMode === 'ur' && $item->urdu_body)
                        <div class="p-6 bg-slate-50/80 rounded-2xl border border-slate-200 text-slate-800 space-y-4">
                            {!! nl2br(e($item->urdu_body)) !!}
                        </div>
                    @else
                        {!! nl2br(e($item->body)) !!}
                    @endif
                </div>

                <!-- Video embed (if type is video) -->
                @if(($item->type?->value ?? $item->type) === 'video')
                    <div class="mt-6">
                        <div class="relative w-full aspect-video bg-[#0F172A] rounded-2xl overflow-hidden shadow-xl flex items-center justify-center border border-slate-800 group">
                            <div class="text-center p-6 space-y-3">
                                <div class="w-16 h-16 rounded-2xl bg-[#00C48C] text-slate-950 flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-white">Video Player Placeholder</p>
                                <p class="text-xs text-slate-400">High-speed video playback with zero buffering</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Interactive Concept Check Mini-Quiz Box -->
                @if($item->quiz_data && isset($item->quiz_data['question']))
                    <div class="mt-10 pt-8 border-t border-slate-100">
                        <div class="bg-[#F8FAFC] border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs space-y-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-[#00C48C]/15 text-[#00A86B] flex items-center justify-center font-bold text-sm">🧠</span>
                                    <h3 class="text-base sm:text-lg font-bold text-[#0F172A]">Quick Concept Check</h3>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-white text-slate-600 rounded-md border border-slate-200">
                                    1 Question Test
                                </span>
                            </div>

                            <p class="text-sm sm:text-base font-semibold text-slate-800">
                                {{ $item->quiz_data['question'] }}
                            </p>

                            <!-- Options List -->
                            <div class="space-y-2.5">
                                @foreach($item->quiz_data['options'] ?? [] as $optIdx => $optionText)
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl border transition-all cursor-pointer {{ $selectedOption === $optIdx ? 'bg-emerald-50 border-[#00C48C] text-slate-900 font-semibold' : 'bg-white border-slate-200 hover:border-slate-300 text-slate-700' }}">
                                        <input type="radio" wire:model="selectedOption" value="{{ $optIdx }}" class="text-[#00C48C] focus:ring-[#00C48C]">
                                        <span class="text-xs sm:text-sm">{{ $optionText }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Submit button & Feedback -->
                            <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <button type="button" wire:click="submitQuiz"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#0F172A] hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider transition-all">
                                    Submit Answer
                                </button>

                                @if($quizSubmitted)
                                    <div class="text-xs font-semibold {{ $quizCorrect ? 'text-[#008f62]' : 'text-amber-700' }}">
                                        {{ $quizCorrect ? '🎉 Correct Answer!' : '⚠️ Incorrect. Re-read and try again!' }}
                                    </div>
                                @endif
                            </div>

                            @if($quizSubmitted && $quizFeedback)
                                <div class="p-4 rounded-xl text-xs leading-relaxed {{ $quizCorrect ? 'bg-emerald-50 border border-emerald-200 text-[#008f62]' : 'bg-amber-50 border border-amber-200 text-amber-900' }}">
                                    <span class="font-bold">Explanation:</span> {{ $quizFeedback }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Article Completion Bar -->
                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $isCompleted ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center font-bold text-lg">
                            ✓
                        </div>
                        <div>
                            <p class="text-xs font-bold text-[#0F172A]">
                                {{ $isCompleted ? 'You completed this article!' : 'Finished reading?' }}
                            </p>
                            <p class="text-[11px] text-slate-500">
                                {{ $isCompleted ? 'Earned +3 XP toward your weekly rank.' : 'Mark it completed to level up your streak.' }}
                            </p>
                        </div>
                    </div>

                    <button type="button" wire:click="markAsCompleted"
                        class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $isCompleted ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-[#00C48C] hover:bg-[#00A86B] text-slate-950 font-extrabold shadow-sm' }}">
                        {{ $isCompleted ? 'Mark as Unread' : 'Mark as Read (+3 XP)' }}
                    </button>
                </div>

            @endif
        </article>

        <!-- In-Article Community Discussion & Q&A Section -->
        <section class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-lg">💬</span>
                    <h3 class="text-lg font-bold text-[#0F172A]">Discussion & Questions</h3>
                </div>
                <span class="text-xs font-semibold text-slate-500">
                    {{ $item->comments->count() }} {{ Str::plural('thought', $item->comments->count()) }}
                </span>
            </div>

            <!-- Comment Input Box -->
            @auth
                <form wire:submit.prevent="postComment" class="space-y-3">
                    <textarea wire:model="newComment" rows="3"
                        placeholder="Have a question about this concept or want to share your perspective? Ask here..."
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3.5 focus:border-[#00C48C] focus:ring-[#00C48C] resize-none"></textarea>
                    
                    @error('newComment')
                        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                    @enderror

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-5 py-2 bg-[#00C48C] hover:bg-[#00A86B] text-slate-950 font-bold text-xs rounded-xl shadow-xs transition-all">
                            Post to Community
                        </button>
                    </div>
                </form>

                @if(session()->has('comment_message'))
                    <div class="p-3 bg-emerald-50 text-[#008f62] rounded-xl text-xs font-semibold">
                        {{ session('comment_message') }}
                    </div>
                @endif
            @else
                <div class="bg-slate-50 rounded-2xl p-5 text-center text-xs text-slate-600 border border-slate-200">
                    <a href="{{ route('login') }}" wire:navigate class="font-bold text-[#00A86B] hover:underline">Log in</a>
                    to ask a question or join the conversation on this lesson.
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-4 pt-2">
                @forelse($item->comments as $comment)
                    <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2 font-bold text-[#0F172A]">
                                <div class="w-6 h-6 rounded-full bg-[#00C48C]/15 text-[#00A86B] flex items-center justify-center text-[10px] font-black">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <span>{{ $comment->user->name }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 pl-8 leading-relaxed">
                            {{ $comment->comment }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">No questions posted yet. Be the first to ask!</p>
                @endforelse
            </div>
        </section>

        <!-- Related Lessons Section -->
        @if($relatedItems->count() > 0)
            <div class="space-y-4 pt-4">
                <h3 class="text-base font-bold text-[#0F172A]">Up Next in Curriculum</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedItems as $rel)
                        <a href="{{ route('learn.show', $rel->slug) }}" wire:navigate
                            class="group bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs hover:border-[#00C48C]/50 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#00A86B] block mb-1">
                                    {{ $rel->skill_level?->value ?? 'Module' }}
                                </span>
                                <h4 class="text-xs sm:text-sm font-bold text-[#0F172A] group-hover:text-[#00A86B] transition-colors line-clamp-2">
                                    {{ $rel->title }}
                                </h4>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                                <span>{{ $rel->duration_minutes }} mins</span>
                                <span class="group-hover:translate-x-1 transition-transform text-[#00C48C]">Read →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
