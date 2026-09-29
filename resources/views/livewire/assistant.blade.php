<div class="dash-bg min-h-[calc(100vh-4rem)] py-6 px-4 sm:px-6 lg:px-8"
     style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .dash-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% -10%, rgba(57,229,84,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 60% 50% at 90% 100%, rgba(57,229,84,0.06) 0%, transparent 55%);
        }
    </style>

    <div class="max-w-3xl mx-auto flex flex-col h-[calc(100vh-7rem)] max-h-[850px]"
         x-data="assistantChat()"
         x-init="scrollToBottom()">

        {{-- Page Header --}}
        <div class="mb-4 shrink-0 flex items-center justify-between">
            <div>
                <div class="inline-flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-[#39e554] shadow-[0_0_8px_#39e554]"></span>
                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-[#168a43]">AI Assistant</p>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 flex items-center gap-3">
                    FinPulse
                    <span class="bg-clip-text text-transparent" style="background:linear-gradient(135deg,#0b542c 0%,#39e554 100%);">Assistant</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#0b542c] text-white shadow-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39e554] animate-pulse"></span>
                        Instant AI
                    </span>
                </h1>
            </div>
        </div>

        {{-- Main Chat Window (Matching Reference Design with #39e554) --}}
        <div class="rounded-[28px] overflow-hidden shadow-[0_20px_50px_-10px_rgba(0,0,0,0.15)] border border-slate-200/80 flex flex-col flex-1 bg-white">

            {{-- ── WAVY HEADER (Matching Reference) ── --}}
            <div class="relative shrink-0 text-white pt-5 px-6 pb-7 overflow-hidden bg-gradient-to-r from-[#0b542c] via-[#168a43] to-[#39e554]">
                <div class="flex items-center justify-between relative z-10 mb-2">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full bg-white/25 p-0.5 ring-2 ring-white/95 shadow-md flex items-center justify-center overflow-hidden">
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-[#0b542c] to-[#39e554] flex items-center justify-center text-white">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-white/85 leading-tight">Chat with</p>
                            <h2 class="text-lg font-bold text-white leading-tight tracking-tight">FinPulse AI</h2>
                        </div>
                    </div>

                    @if(count($messages) > 0)
                        <button wire:click="clearChat"
                                id="assistant-clear-btn"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold text-white/90 bg-white/15 hover:bg-white/25 transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Clear
                        </button>
                    @endif
                </div>

                {{-- Status line --}}
                <div class="flex items-center gap-1.5 text-xs text-white font-medium pl-0.5 relative z-10">
                    <span class="w-2 h-2 rounded-full bg-[#39e554] shadow-[0_0_8px_#39e554]"></span>
                    <span>We reply immediately</span>
                </div>

                {{-- Wave Curve into white background --}}
                <div class="absolute -bottom-0.5 left-0 right-0 overflow-hidden leading-none pointer-events-none z-0">
                    <svg class="w-full h-5 text-white fill-current block" viewBox="0 0 500 50" preserveAspectRatio="none">
                        <path d="M0,20 C160,50 340,0 500,22 L500,50 L0,50 Z"></path>
                    </svg>
                </div>
            </div>

            {{-- ── SCROLLABLE MESSAGES CONTAINER (Pure White background) ── --}}
            <div class="flex-1 overflow-y-auto px-6 py-6 space-y-4 bg-white"
                 id="assistant-messages"
                 x-ref="messagesArea"
                 wire:poll.100ms="$refresh"
                 style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">

                {{-- Empty State --}}
                @if(count($messages) === 0 && !$isThinking)
                    <div class="flex flex-col items-center justify-center h-full py-12 text-center" id="assistant-empty-state">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center mb-4 bg-[#39e554]/15 text-[#0b542c]">
                            <svg class="w-7 h-7 text-[#168a43]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 mb-1.5">Ask anything about FinPulse</h2>
                        <p class="text-sm text-slate-500 max-w-sm leading-relaxed mb-6 font-medium">
                            I will answer strictly from our approved knowledge base — courses, finance principles, community, and platform features.
                        </p>
                        <div class="flex flex-wrap gap-2.5 justify-center max-w-lg">
                            @foreach(['What courses are available?', 'How does the community work?', 'What are the pricing plans?'] as $suggestion)
                                <button wire:click="$set('question', '{{ $suggestion }}')"
                                        id="assistant-suggest-{{ $loop->index }}"
                                        class="text-xs px-4 py-2 rounded-full font-semibold transition-all border border-slate-200 bg-slate-50 text-slate-700 hover:border-[#39e554] hover:bg-[#39e554]/10 hover:text-[#0b542c] shadow-2xs hover:scale-[1.02] cursor-pointer">
                                    💬 {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Chat Messages --}}
                @foreach($messages as $index => $message)
                    <div class="flex flex-col {{ $message['role'] === 'user' ? 'items-end' : 'items-start' }}"
                         id="assistant-msg-{{ $index }}">
                        @if($message['role'] === 'user')
                            {{-- User Bubble: #39e554 gradient pill with white text --}}
                            <div class="max-w-[75%] px-5 py-3 rounded-2xl rounded-tr-xs text-sm font-normal leading-relaxed text-white shadow-xs bg-gradient-to-r from-[#0b542c] via-[#168a43] to-[#39e554]">
                                {{ $message['content'] }}
                            </div>
                        @else
                            {{-- Assistant Bubble: Soft grey card --}}
                            <div class="max-w-[80%] px-5 py-3.5 rounded-2xl rounded-tl-xs text-sm leading-relaxed text-slate-800 bg-[#f3f5f4] border border-slate-200/60 shadow-2xs">
                                {{ $message['content'] }}

                                @if(!empty($message['sources']))
                                    <div class="mt-2.5 pt-2.5 border-t border-slate-200/60 flex flex-wrap gap-1.5">
                                        @foreach($message['sources'] as $source)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium text-[#0b542c] bg-white border border-slate-200 shadow-2xs">
                                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                {{ $source['name'] }}
                                                @if($source['page'] !== null)
                                                    · p.{{ $source['page'] }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Thinking Indicator --}}
                @if($isThinking)
                    <div class="flex items-start" id="assistant-thinking">
                        <div class="px-5 py-3.5 rounded-2xl rounded-tl-xs bg-[#f3f5f4] border border-slate-200/60 flex items-center gap-2 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-[#39e554] animate-bounce"></span>
                            <span class="w-2 h-2 rounded-full bg-[#39e554] animate-bounce" style="animation-delay: 0.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-[#39e554] animate-bounce" style="animation-delay: 0.3s"></span>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Educational disclaimer --}}
            <div class="px-6 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center gap-2 text-[11px] text-slate-500">
                <svg class="w-3.5 h-3.5 text-[#168a43] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Educational information only, not investment advice.</span>
            </div>

            {{-- ── FOOTER / INPUT AREA (Matching Reference Exactly) ── --}}
            <div class="shrink-0 bg-white border-t border-slate-100 px-6 pt-3.5 pb-4 relative">
                <form wire:submit.prevent="sendMessage" id="assistant-form">
                    {{-- Input textarea with placeholder --}}
                    <div class="relative">
                        <textarea wire:model="question"
                                  id="assistant-input"
                                  rows="1"
                                  placeholder="Enter your message..."
                                  class="w-[calc(100%-3.5rem)] bg-transparent text-sm text-slate-800 placeholder-slate-400 resize-none outline-none leading-relaxed max-h-28"
                                  style="scrollbar-width: none;"
                                  x-ref="questionInput"
                                  @keydown.enter.prevent="if(!$event.shiftKey) { $wire.sendMessage(); }"
                                  @input="autoGrow($el)"
                                  :disabled="$wire.isThinking"></textarea>

                        {{-- Floating Circular Send Button with #39e554 gradient --}}
                        <button type="submit"
                                id="assistant-send-btn"
                                class="absolute right-0 bottom-0 w-12 h-12 rounded-full flex items-center justify-center shrink-0 shadow-lg bg-gradient-to-r from-[#0b542c] to-[#39e554] text-white hover:scale-105 active:scale-95 transition-all disabled:opacity-40 disabled:scale-100 disabled:cursor-not-allowed cursor-pointer"
                                :disabled="$wire.isThinking || $wire.question.trim() === ''"
                                title="Send message">
                            <svg class="w-5 h-5 text-white transform rotate-45 -translate-y-0.5 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Bottom Action Row (Icons on Left | Powered by FinPulse in Center) --}}
                    <div class="flex items-center justify-between mt-3 pt-1 text-slate-400 pr-16">
                        <div class="flex items-center gap-3">
                            <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="AI Bot">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="8" width="18" height="12" rx="3" stroke-width="2"/>
                                    <path stroke-linecap="round" stroke-width="2" d="M12 4v4M9 13h.01M15 13h.01M9 17h6"/>
                                    <circle cx="3" cy="14" r="1" fill="currentColor"/>
                                    <circle cx="21" cy="14" r="1" fill="currentColor"/>
                                </svg>
                            </button>
                            <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="Attach file">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                            </button>
                            <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="Add emoji">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            <span>POWERED BY</span>
                            <div class="flex items-center gap-1 font-extrabold text-[#0b542c] tracking-normal">
                                <svg class="w-3 h-3 text-[#39e554]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                </svg>
                                <span>FinPulse</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
function assistantChat() {
    return {
        scrollToBottom() {
            this.$nextTick(() => {
                const el = this.$refs.messagesArea;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },
        autoGrow(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 112) + 'px';
        },
        init() {
            document.addEventListener('livewire:update', () => this.scrollToBottom());
            this.scrollToBottom();
        }
    }
}
</script>
