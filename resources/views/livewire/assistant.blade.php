<div class="dash-bg min-h-[calc(100vh-4rem)] py-6 px-4 sm:px-6 lg:px-8"
     style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        /* ── Mesh gradient background ── */
        .dash-bg {
            background-color: #f0fdf4;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% -10%, rgba(57,229,84,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 60% 50% at 90% 100%, rgba(40,160,74,0.08) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 60% 40%, rgba(57,229,84,0.05) 0%, transparent 50%);
        }

        .fp-assistant-bg {
            background: linear-gradient(165deg, #061A14 0%, #0B2A20 50%, #03100C 100%);
            border: 1px solid rgba(0, 196, 140, 0.28);
            box-shadow: 0 0 50px rgba(57, 229, 84, 0.08), 0 25px 60px -15px rgba(3, 16, 12, 0.7);
        }
        .fp-chat-header {
            background: linear-gradient(135deg, rgba(6, 26, 20, 0.95), rgba(11, 42, 32, 0.85));
            border-bottom: 1px solid rgba(0, 196, 140, 0.2);
            backdrop-filter: blur(12px);
        }
        .fp-msg-user {
            background: linear-gradient(135deg, #39E554 0%, #00C48C 50%, #28a04a 100%);
            color: #03100C;
            box-shadow: 0 4px 18px rgba(57, 229, 84, 0.25);
        }
        .fp-msg-ai {
            background: rgba(11, 42, 32, 0.6);
            border: 1px solid rgba(0, 196, 140, 0.22);
            color: rgba(240, 253, 248, 0.95);
            backdrop-filter: blur(8px);
        }
        .fp-msg-ai:hover { border-color: rgba(57, 229, 84, 0.4); }
        .fp-thinking-dot {
            animation: fp-bounce 1.2s ease-in-out infinite;
        }
        .fp-thinking-dot:nth-child(1) { background: #39E554; }
        .fp-thinking-dot:nth-child(2) { animation-delay: 0.2s; background: #00C48C; }
        .fp-thinking-dot:nth-child(3) { animation-delay: 0.4s; background: #34D399; }
        @keyframes fp-bounce {
            0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
            40% { transform: translateY(-6px); opacity: 1; }
        }
        .fp-input-wrap {
            background: rgba(3, 16, 12, 0.85);
            border: 1.5px solid rgba(0, 196, 140, 0.28);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .fp-input-wrap:focus-within {
            border-color: #39E554;
            box-shadow: 0 0 0 3px rgba(57, 229, 84, 0.18), 0 0 25px rgba(57, 229, 84, 0.12);
        }
        .fp-send-btn {
            background: linear-gradient(135deg, #39E554 0%, #00C48C 50%, #28a04a 100%);
            color: #03100C;
            box-shadow: 0 4px 14px rgba(57, 229, 84, 0.35);
            transition: all 0.2s ease;
        }
        .fp-send-btn:hover:not(:disabled) {
            opacity: 0.95;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(57, 229, 84, 0.5);
        }
        .fp-send-btn:disabled { opacity: 0.35; cursor: not-allowed; transform: none; box-shadow: none; }
        .fp-source-tag {
            background: rgba(0, 196, 140, 0.12);
            border: 1px solid rgba(57, 229, 84, 0.3);
            color: #34D399;
            transition: all 0.2s ease;
        }
        .fp-source-tag:hover {
            background: rgba(0, 196, 140, 0.22);
            border-color: #39E554;
            color: #ffffff;
        }
        .fp-disclaimer {
            background: rgba(6, 26, 20, 0.7);
            border: 1px solid rgba(0, 196, 140, 0.2);
        }
        .fp-clear-btn:hover {
            background: rgba(0, 196, 140, 0.12);
            border-color: rgba(57, 229, 84, 0.35);
            color: #34D399;
        }
        .fp-msg-enter {
            animation: fp-fade-up 0.3s ease-out;
        }
        @keyframes fp-fade-up {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fp-avatar-ai {
            background: linear-gradient(135deg, #39E554 0%, #00C48C 50%, #28a04a 100%);
            box-shadow: 0 4px 14px rgba(57, 229, 84, 0.35);
        }
        .fp-avatar-user {
            background: #0B2A20;
            border: 1.5px solid #39E554;
            color: #39E554;
        }
        .fp-scroll-area::-webkit-scrollbar { width: 6px; }
        .fp-scroll-area::-webkit-scrollbar-track { background: transparent; }
        .fp-scroll-area::-webkit-scrollbar-thumb {
            background: rgba(0, 196, 140, 0.25);
            border-radius: 10px;
        }
        .fp-scroll-area::-webkit-scrollbar-thumb:hover {
            background: rgba(57, 229, 84, 0.45);
        }
    </style>

    <div class="max-w-4xl mx-auto flex flex-col h-[calc(100vh-7rem)] max-h-[880px]"
         x-data="assistantChat()"
         x-init="scrollToBottom()">

        {{-- Page header --}}
        <div class="mb-4 shrink-0 flex items-center justify-between">
            <div>
                <div class="inline-flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-[#39E554] shadow-[0_0_8px_#39E554]"></span>
                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-[#28a04a]">AI Assistant</p>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 flex items-center gap-3">
                    FinPulse
                    <span class="bg-clip-text text-transparent"
                          style="background:linear-gradient(135deg,#00A86B 0%,#28a04a 50%,#065F46 100%);">Assistant</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 border border-emerald-300 text-emerald-800 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39E554] animate-pulse"></span>
                        Powered by Groq
                    </span>
                </h1>
            </div>
        </div>

        {{-- Chat window --}}
        <div class="fp-assistant-bg rounded-3xl flex flex-col flex-1 overflow-hidden">

            {{-- Chat header --}}
            <div class="fp-chat-header px-5 py-3.5 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="fp-avatar-ai w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold text-white leading-tight">FinPulse AI</p>
                            <span class="w-1.5 h-1.5 rounded-full bg-[#39E554]"></span>
                        </div>
                        <p class="text-[11px] text-emerald-400/70 leading-tight">Answers from your knowledge base</p>
                    </div>
                </div>
                @if(count($messages) > 0)
                    <button wire:click="clearChat"
                            id="assistant-clear-btn"
                            class="fp-clear-btn flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-300/70 border border-emerald-500/20 bg-emerald-500/5 transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear
                    </button>
                @endif
            </div>

            {{-- Messages area --}}
            <div class="fp-scroll-area flex-1 overflow-y-auto px-4 sm:px-6 py-5 space-y-5"
                 id="assistant-messages"
                 x-ref="messagesArea"
                 wire:poll.100ms="$refresh">

                {{-- Empty state --}}
                @if(count($messages) === 0 && !$isThinking)
                    <div class="flex flex-col items-center justify-center h-full py-12 text-center" id="assistant-empty-state">
                        <div class="fp-avatar-ai w-16 h-16 rounded-2xl flex items-center justify-center mb-5 shadow-2xl">
                            <svg class="w-8 h-8 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-extrabold text-white mb-2">Ask anything about FinPulse</h2>
                        <p class="text-sm text-emerald-100/70 max-w-sm leading-relaxed mb-6 font-medium">
                            I'll answer strictly from our knowledge base — courses, economics, finance principles, community, and pricing.
                        </p>
                        {{-- Suggested questions --}}
                        <div class="flex flex-wrap gap-2.5 justify-center max-w-lg">
                            @foreach(['What courses are available?', 'How does the community work?', 'What are the pricing plans?'] as $suggestion)
                                <button wire:click="$set('question', '{{ $suggestion }}')"
                                        id="assistant-suggest-{{ $loop->index }}"
                                        class="text-xs px-4 py-2 rounded-full font-semibold transition-all duration-200 border border-emerald-500/30 bg-emerald-950/60 text-emerald-300 hover:bg-emerald-500/20 hover:border-[#39E554] hover:text-white shadow-sm hover:scale-[1.02]">
                                    {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Chat messages --}}
                @foreach($messages as $index => $message)
                    <div class="fp-msg-enter flex gap-3 {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}"
                         id="assistant-msg-{{ $index }}">

                        {{-- AI avatar (left side) --}}
                        @if($message['role'] === 'assistant')
                            <div class="fp-avatar-ai w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="max-w-[80%]">
                            {{-- Bubble --}}
                            @if($message['role'] === 'user')
                                <div class="fp-msg-user px-4 py-2.5 rounded-2xl rounded-tr-sm text-sm font-semibold leading-relaxed">
                                    {{ $message['content'] }}
                                </div>
                            @else
                                <div class="fp-msg-ai px-4 py-3 rounded-2xl rounded-tl-sm text-sm leading-relaxed">
                                    {{ $message['content'] }}
                                </div>

                                {{-- Sources attribution (from DB, never from model) --}}
                                @if(!empty($message['sources']))
                                    <div class="mt-2 flex flex-wrap gap-1.5">
                                        @foreach($message['sources'] as $source)
                                            <span class="fp-source-tag inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold">
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
                            @endif
                        </div>

                        {{-- User avatar (right side) --}}
                        @if($message['role'] === 'user')
                            <div class="fp-avatar-user w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <span class="text-xs font-black">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Thinking indicator --}}
                @if($isThinking)
                    <div class="flex gap-3 justify-start" id="assistant-thinking">
                        <div class="fp-avatar-ai w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-slate-950 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </div>
                        <div class="fp-msg-ai px-4 py-3.5 rounded-2xl rounded-tl-sm flex items-center gap-1.5">
                            <span class="fp-thinking-dot w-2 h-2 rounded-full"></span>
                            <span class="fp-thinking-dot w-2 h-2 rounded-full"></span>
                            <span class="fp-thinking-dot w-2 h-2 rounded-full"></span>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Disclaimer --}}
            <div class="fp-disclaimer mx-4 mb-3 mt-0 px-3.5 py-2.5 rounded-2xl flex items-center gap-2.5 shrink-0">
                <svg class="w-4 h-4 shrink-0 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-[11px] font-medium text-emerald-200/80">
                    Educational information only, not investment advice.
                </p>
            </div>

            {{-- Input area --}}
            <div class="px-4 pb-4 shrink-0">
                <form wire:submit.prevent="sendMessage" id="assistant-form">
                    <div class="fp-input-wrap rounded-2xl flex items-end gap-2.5 px-4 py-3">
                        <textarea wire:model="question"
                                  id="assistant-input"
                                  rows="1"
                                  placeholder="Ask something about FinPulse…"
                                  class="flex-1 bg-transparent text-sm text-white placeholder-emerald-100/35 resize-none outline-none leading-relaxed max-h-28 overflow-y-auto"
                                  style="scrollbar-width: none;"
                                  x-ref="questionInput"
                                  @keydown.enter.prevent="if(!$event.shiftKey) { $wire.sendMessage(); }"
                                  @input="autoGrow($el)"
                                  :disabled="$wire.isThinking"></textarea>
                        <button type="submit"
                                id="assistant-send-btn"
                                class="fp-send-btn w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                :disabled="$wire.isThinking || $wire.question.trim() === ''">
                            <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-[10px] text-emerald-300/40 text-center mt-2.5 font-medium">
                        Press Enter to send · Shift+Enter for new line · 5 questions per minute
                    </p>
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
            // Scroll on every Livewire update
            document.addEventListener('livewire:update', () => this.scrollToBottom());
            this.scrollToBottom();
        }
    }
}
</script>
