<div x-data="{
        isOpen: false,
        scrollToBottom() {
            this.$nextTick(() => {
                const el = this.$refs.widgetMessagesArea;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },
        autoGrow(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 80) + 'px';
        },
        openChat() {
            this.isOpen = true;
            this.scrollToBottom();
            this.$nextTick(() => {
                if (this.$refs.widgetInput) this.$refs.widgetInput.focus();
            });
        },
        closeChat() {
            this.isOpen = false;
        }
     }"
     x-init="
        $watch('$wire.messages', () => scrollToBottom());
        $watch('$wire.isThinking', () => scrollToBottom());
     "
     @open-assistant.window="openChat()"
     @close-assistant.window="closeChat()"
     class="font-sans relative z-[9999]">

    {{-- ══════════════════════════════════════════════════════
         FLOATING LAUNCHER BUTTON (Visible when closed)
         ══════════════════════════════════════════════════════ --}}
    <div x-show="!isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-75"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed bottom-6 right-6 z-[9999]">
        <button type="button"
                @click="openChat()"
                onclick="window.dispatchEvent(new CustomEvent('open-assistant'))"
                id="fp-widget-launcher-btn"
                class="flex items-center gap-3 pl-2 pr-4 py-2 rounded-full shadow-[0_10px_30px_rgba(57,229,84,0.35)] bg-gradient-to-r from-[#0b542c] via-[#168a43] to-[#39e554] text-white transition-all duration-300 hover:scale-105 hover:shadow-[0_14px_35px_rgba(57,229,84,0.45)] cursor-pointer group"
                aria-label="Open AI Assistant Chat Window">
            <div class="relative w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-white text-[#0b542c] shadow-sm">
                <svg class="w-5 h-5 text-[#0b542c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-[#39e554] border-2 border-white rounded-full"></span>
            </div>
            <div class="flex flex-col text-left">
                <span class="text-xs font-bold tracking-tight text-white flex items-center gap-1.5">
                    Chat with us
                </span>
                <span class="text-[10px] text-white/90 font-medium">We reply immediately</span>
            </div>
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════════
         POPUP CHAT WINDOW (Visible when open)
         ══════════════════════════════════════════════════════ --}}
    <div x-show="isOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-[9999] w-[calc(100vw-2rem)] sm:w-[390px] max-w-[400px] h-[610px] max-h-[86vh] rounded-[28px] overflow-hidden shadow-[0_20px_60px_-10px_rgba(0,0,0,0.3)] border border-slate-100 flex flex-col bg-white">

        {{-- ── WAVY HEADER (Matching Reference with #39e554 gradient) ── --}}
        <div class="relative shrink-0 text-white pt-5 px-5 pb-6 overflow-hidden bg-gradient-to-r from-[#0b542c] via-[#168a43] to-[#39e554]">
            {{-- Top row: Avatar, Info, Action icons --}}
            <div class="flex items-center justify-between relative z-10 mb-2.5">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-11 h-11 rounded-full bg-white/25 p-0.5 ring-2 ring-white/95 shadow-md flex items-center justify-center overflow-hidden">
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-[#0b542c] to-[#39e554] flex items-center justify-center text-white font-bold text-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-white/85 leading-tight">Chat with</p>
                        <h2 class="text-base font-bold text-white leading-tight tracking-tight">FinPulse AI</h2>
                    </div>
                </div>

                {{-- Action Icons (⋮ menu & ⌄ chevron) --}}
                <div class="flex items-center gap-1 text-white">
                    @if(count($messages) > 0)
                        <button type="button"
                                wire:click="clearChat"
                                class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors cursor-pointer"
                                title="Clear conversation">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </button>
                    @endif
                    <button type="button"
                            @click="closeChat()"
                            class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors cursor-pointer"
                            title="Close chat">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Status line: "• We reply immediately" --}}
            <div class="flex items-center gap-1.5 text-xs text-white font-medium pl-0.5 relative z-10">
                <span class="w-2 h-2 rounded-full bg-[#39e554] shadow-[0_0_8px_#39e554]"></span>
                <span>We reply immediately</span>
            </div>

            {{-- Bottom Wave Curve into white background --}}
            <div class="absolute -bottom-0.5 left-0 right-0 overflow-hidden leading-none pointer-events-none z-0">
                <svg class="w-full h-4 sm:h-5 text-white fill-current block" viewBox="0 0 500 50" preserveAspectRatio="none">
                    <path d="M0,20 C160,50 340,0 500,22 L500,50 L0,50 Z"></path>
                </svg>
            </div>
        </div>

        {{-- ── SCROLLABLE MESSAGES CONTAINER (Pure White background) ── --}}
        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-3.5 bg-white"
             id="fp-widget-messages"
             x-ref="widgetMessagesArea"
             wire:poll.100ms="$refresh"
             style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">

            {{-- Empty State --}}
            @if(count($messages) === 0 && !$isThinking)
                <div class="flex flex-col items-center justify-center h-full py-6 text-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 bg-[#39e554]/15 text-[#0b542c]">
                        <svg class="w-6 h-6 text-[#168a43]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 mb-1">Ask anything about FinPulse</h3>
                    <p class="text-xs text-slate-500 max-w-[260px] leading-relaxed mb-4">
                        Ask anything about courses, finances, and platform features.
                    </p>
                    {{-- Suggested questions --}}
                    <div class="flex flex-col gap-2 w-full max-w-[300px]">
                        @foreach(['What courses are available?', 'How does the community work?', 'What are the pricing plans?'] as $suggestion)
                            <button type="button"
                                    wire:click="$set('question', '{{ $suggestion }}')"
                                    class="text-left text-xs px-3.5 py-2.5 rounded-xl font-medium transition-all border border-slate-200 bg-slate-50 text-slate-700 hover:border-[#39e554] hover:bg-[#39e554]/10 hover:text-[#0b542c] shadow-2xs cursor-pointer">
                                💬 {{ $suggestion }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Message Bubbles --}}
            @foreach($messages as $index => $message)
                <div class="flex flex-col {{ $message['role'] === 'user' ? 'items-end' : 'items-start' }}">
                    @if($message['role'] === 'user')
                        {{-- User Bubble: #39e554 gradient pill with white text --}}
                        <div class="max-w-[85%] px-4 py-2.5 rounded-2xl rounded-tr-xs text-xs font-normal leading-relaxed text-white shadow-xs bg-gradient-to-r from-[#0b542c] via-[#168a43] to-[#39e554]">
                            {{ $message['content'] }}
                        </div>
                    @else
                        {{-- Assistant Bubble: Soft grey/white card matching reference --}}
                        <div class="max-w-[88%] px-4 py-3 rounded-2xl rounded-tl-xs text-xs leading-relaxed text-slate-800 bg-[#f3f5f4] border border-slate-200/60 shadow-2xs">
                            {{ $message['content'] }}

                            @if(!empty($message['sources']))
                                <div class="mt-2 pt-2 border-t border-slate-200/60 flex flex-wrap gap-1">
                                    @foreach($message['sources'] as $source)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium text-[#0b542c] bg-white border border-slate-200 shadow-2xs">
                                            <svg class="w-2.5 h-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="flex items-start">
                    <div class="px-4 py-3 rounded-2xl rounded-tl-xs bg-[#f3f5f4] border border-slate-200/60 flex items-center gap-1.5 shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39e554] animate-bounce"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39e554] animate-bounce" style="animation-delay: 0.15s"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39e554] animate-bounce" style="animation-delay: 0.3s"></span>
                    </div>
                </div>
            @endif

        </div>

        {{-- Educational disclaimer --}}
        <div class="px-4 py-1.5 bg-slate-50/80 border-t border-slate-100 flex items-center gap-1.5 text-[10px] text-slate-500">
            <svg class="w-3 h-3 text-[#168a43] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Educational information only, not investment advice.</span>
        </div>

        {{-- ── FOOTER / INPUT AREA (Matching Reference Exactly) ── --}}
        <div class="shrink-0 bg-white border-t border-slate-100 px-4 pt-3 pb-3 relative">
            <form wire:submit.prevent="sendMessage">
                {{-- Input textarea with placeholder --}}
                <div class="relative">
                    <textarea wire:model="question"
                              x-ref="widgetInput"
                              rows="1"
                              placeholder="Enter your message..."
                              class="w-[calc(100%-3rem)] bg-transparent text-xs text-slate-800 placeholder-slate-400 resize-none outline-none leading-relaxed max-h-20"
                              style="scrollbar-width: none;"
                              @keydown.enter.prevent="if(!$event.shiftKey) { $wire.sendMessage(); }"
                              @input="autoGrow($el)"
                              :disabled="$wire.isThinking"></textarea>

                    {{-- Floating Circular Send Button with #39e554 gradient --}}
                    <button type="submit"
                            class="absolute right-0 bottom-0 w-11 h-11 rounded-full flex items-center justify-center shrink-0 shadow-lg bg-gradient-to-r from-[#0b542c] to-[#39e554] text-white hover:scale-105 active:scale-95 transition-all disabled:opacity-40 disabled:scale-100 disabled:cursor-not-allowed cursor-pointer"
                            :disabled="$wire.isThinking || $wire.question.trim() === ''"
                            title="Send message">
                        <svg class="w-4 h-4 text-white transform rotate-45 -translate-y-0.5 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    </button>
                </div>

                {{-- Bottom Action Row (Bot, Clip, Smiley on Left | Powered by FinPulse in Center) --}}
                <div class="flex items-center justify-between mt-2.5 pt-1 text-slate-400 pr-12">
                    {{-- 3 icons on left --}}
                    <div class="flex items-center gap-2.5">
                        {{-- Bot face icon --}}
                        <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="AI Bot">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="8" width="18" height="12" rx="3" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-width="2" d="M12 4v4M9 13h.01M15 13h.01M9 17h6"/>
                                <circle cx="3" cy="14" r="1" fill="currentColor"/>
                                <circle cx="21" cy="14" r="1" fill="currentColor"/>
                            </svg>
                        </button>
                        {{-- Paperclip icon --}}
                        <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="Attach file">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        {{-- Smiley icon --}}
                        <button type="button" class="hover:text-[#39e554] transition-colors cursor-pointer" title="Add emoji">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Powered by FinPulse (matches "POWERED BY TIDIO" badge) --}}
                    <div class="flex items-center gap-1 text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                        <span>POWERED BY</span>
                        <div class="flex items-center gap-1 font-extrabold text-[#0b542c] tracking-normal">
                            <svg class="w-2.5 h-2.5 text-[#39e554]" fill="currentColor" viewBox="0 0 24 24">
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
