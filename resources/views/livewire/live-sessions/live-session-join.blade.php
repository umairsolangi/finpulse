<div wire:poll.5s="checkSessionStatus" class="h-screen w-full bg-slate-950 text-slate-100 flex flex-col justify-between overflow-hidden" style="font-family:'Plus Jakarta Sans',sans-serif;">

    {{-- Top Navigation / Header --}}
    <header class="bg-slate-900/90 backdrop-blur-md border-b border-slate-800/80 px-4 sm:px-6 py-3 flex items-center justify-between shrink-0 z-40">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('live-sessions.index') }}"
                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition-colors shrink-0"
                title="Back to Sessions">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $isEnded ? 'bg-slate-800 text-slate-400 border border-slate-700' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                        <span class="w-2 h-2 rounded-full {{ $isEnded ? 'bg-slate-500' : 'bg-red-500 animate-pulse' }}"></span>
                        {{ $isEnded ? 'Session Ended' : 'Live Room' }}
                    </span>
                    <span class="text-xs text-slate-400 truncate hidden sm:inline">
                        Channel: <span class="font-mono text-slate-300">{{ $session->agora_channel_name }}</span>
                    </span>
                </div>
                <h1 class="text-sm sm:text-base font-bold text-white truncate max-w-md sm:max-w-xl">
                    {{ $session->title }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800/70 border border-slate-700/60 text-xs">
                <span class="text-slate-400">Host:</span>
                <span class="font-bold text-slate-200">{{ $session->host->name ?? 'Instructor' }}</span>
                @if($isHost)
                    <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#39E554]/20 text-[#39E554] border border-[#39E554]/40">YOU</span>
                @endif
            </div>

            @if(! $isEnded)
                <span id="call-status-pill" wire:ignore
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    Connecting...
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                    <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                    Concluded
                </span>
            @endif

            @if($isHost && ! $isEnded)
                <button wire:click="openParticipantsModal" type="button"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700/80 text-xs font-bold transition-all shadow-sm cursor-pointer"
                    title="Manage & Add Participants">
                    <svg class="w-4 h-4 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Participants ({{ count($bookedUserIds) }})</span>
                </button>

                <button type="button"
                    id="btn-end-session-header"
                    class="px-3.5 py-1.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-black text-xs shadow-lg shadow-red-600/30 transition-all flex items-center gap-1.5 cursor-pointer">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span>End Live Session</span>
                </button>
            @endif

            <a href="{{ route('live-sessions.index') }}"
                class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs border border-slate-700 shadow transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Exit</span>
            </a>
        </div>
    </header>

    {{-- Insecure Testing Mode Notice --}}
    @if($testingMode && ! $isEnded)
        <div class="bg-amber-950/80 border-b border-amber-700/50 px-4 py-2.5 text-center text-xs text-amber-200 font-medium">
            <span class="font-bold">⚠️ Notice:</span> Running in Agora Testing Mode (App ID only, no token authentication).
            <span class="text-amber-300/80">This is INSECURE for production — anyone with the App ID could join. Add AGORA_APP_CERTIFICATE in .env before deploying to real users.</span>
        </div>
    @endif

    {{-- Main Stage / Waiting Room / Ended Screen --}}
    <main class="flex-1 min-h-0 p-3 sm:p-4 flex flex-col justify-center items-center relative overflow-hidden">
        @if($isEnded)
            {{-- Ended Session Display --}}
            <div class="max-w-md w-full bg-slate-900/90 border border-slate-800 rounded-3xl p-8 text-center space-y-6 shadow-2xl backdrop-blur-xl">
                <div class="w-20 h-20 rounded-3xl bg-red-950/40 border border-red-800/60 flex items-center justify-center mx-auto text-3xl shadow-inner">
                    🏁
                </div>
                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-500/10 text-red-400 border border-red-500/30">
                        Session Concluded
                    </span>
                    <h2 class="text-xl font-black text-white">{{ $session->title }}</h2>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        This live session has concluded and is no longer broadcasting. Thank you for participating!
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-left space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Ended at:</span>
                        <span class="font-bold text-slate-200">{{ $session->ended_at?->format('M d, Y — h:i A') ?? now()->format('M d, Y — h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Host:</span>
                        <span class="font-bold text-slate-200">{{ $session->host->name ?? 'Instructor' }}</span>
                    </div>
                </div>

                <a href="{{ route('live-sessions.index') }}"
                    class="inline-block w-full py-3 px-4 rounded-xl text-slate-950 font-black text-xs shadow-lg transition-transform hover:-translate-y-0.5"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                    Return to Live Sessions
                </a>
            </div>
        @elseif(! $isJoinable && ! $isHost)
            {{-- Waiting Room Display --}}
            <div class="max-w-md w-full bg-slate-900/90 border border-slate-800 rounded-3xl p-8 text-center space-y-6 shadow-2xl backdrop-blur-xl">
                <div class="w-20 h-20 rounded-3xl bg-slate-800/80 border border-slate-700 flex items-center justify-center mx-auto text-3xl shadow-inner">
                    ⏳
                </div>
                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/30">
                        Waiting Room
                    </span>
                    <h2 class="text-xl font-black text-white">{{ $session->title }}</h2>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ $session->description }}</p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-left space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Scheduled Start:</span>
                        <span class="font-bold text-slate-200">{{ $session->scheduled_at->format('M d, Y — h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Duration:</span>
                        <span class="font-bold text-slate-200">{{ $session->duration_minutes }} minutes</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Host:</span>
                        <span class="font-bold text-slate-200">{{ $session->host->name ?? 'Instructor' }}</span>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs font-medium">
                    This live room activates <strong>10 minutes prior</strong> to scheduled start time (at {{ $session->scheduled_at->subMinutes(10)->format('h:i A') }}). Please keep this page open or refresh when the countdown ends.
                </div>

                <a href="{{ route('live-sessions.index') }}"
                    class="inline-block w-full py-3 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-colors">
                    Back to Live Sessions
                </a>
            </div>
        @else
            {{-- Video Calling Stage --}}
            <div id="video-grid" class="w-full max-w-7xl h-full flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 auto-rows-fr min-h-0">
                
                {{-- Local User Video Card --}}
                <div class="relative bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl flex flex-col justify-center items-center w-full h-full min-h-0 group">
                    {{-- Video player element --}}
                    <div id="local-player" wire:ignore class="absolute inset-0 w-full h-full object-cover"></div>

                    {{-- Placeholder when camera is off --}}
                    <div id="local-avatar-placeholder" class="hidden flex flex-col items-center justify-center space-y-3 z-10">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#28a04a] to-[#39E554] flex items-center justify-center text-3xl font-black text-slate-950 shadow-xl">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <p class="text-xs font-bold text-slate-300">{{ auth()->user()->name ?? 'You' }} (Camera Off)</p>
                    </div>

                    {{-- Overlay Name Badge --}}
                    <div class="absolute bottom-4 left-4 z-20 flex items-center gap-2 bg-slate-950/70 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-800/80 text-xs font-bold text-white shadow-lg">
                        <span id="local-audio-indicator" class="w-2 h-2 rounded-full bg-[#39E554]"></span>
                        <span>{{ auth()->user()->name ?? 'You' }}</span>
                        <span class="text-[10px] text-slate-400 font-normal">({{ $isHost ? 'Host' : 'You' }})</span>
                    </div>

                    {{-- Mute icon overlay if muted --}}
                    <div id="local-muted-badge" class="hidden absolute top-4 right-4 z-20 p-2 rounded-xl bg-red-600/90 text-white shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                        </svg>
                    </div>
                </div>

                {{-- Remote Participants Container --}}
                <div id="remote-playerlist" wire:ignore class="w-full h-full min-h-0 flex flex-col justify-center items-center">
                    {{-- Default empty state when alone in room --}}
                    <div id="empty-room-state" class="w-full h-full bg-slate-900/60 rounded-3xl border border-dashed border-slate-800 flex flex-col items-center justify-center p-8 text-center space-y-3">
                        <div class="w-16 h-16 rounded-2xl bg-slate-800/80 flex items-center justify-center text-2xl shadow-inner text-slate-400">
                            👥
                        </div>
                        <h3 class="text-sm font-bold text-slate-300">Waiting for other participants</h3>
                        <p class="text-xs text-slate-500 max-w-xs leading-relaxed">
                            {{ $isHost ? 'You are connected as the host. Attendees who join will appear on this stage.' : 'You have joined the live session! Waiting for the instructor and other learners to enter.' }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- Permission / Error Toast --}}
            <div id="permission-toast" class="hidden fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-md w-full px-4">
                <div class="bg-red-950/90 border border-red-700/80 text-red-200 px-4 py-3 rounded-2xl shadow-2xl backdrop-blur-md flex items-center gap-3 text-xs">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span id="permission-toast-msg" class="flex-1 font-medium"></span>
                    <button onclick="document.getElementById('permission-toast').classList.add('hidden')" class="text-red-400 hover:text-white font-bold">&times;</button>
                </div>
            </div>
        @endif
    </main>

    {{-- Bottom Control Bar --}}
    @if(! $isEnded && ($isJoinable || $isHost))
        <footer class="bg-slate-900/90 backdrop-blur-md border-t border-slate-800/80 px-4 py-3 shrink-0 z-40">
            <div class="max-w-3xl mx-auto flex items-center justify-center gap-3 sm:gap-5">
                
                {{-- Toggle Audio / Mic --}}
                <button id="btn-toggle-mic" wire:ignore
                    class="flex flex-col items-center gap-1.5 p-2.5 sm:px-5 sm:py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all shadow-md group">
                    <span class="w-6 h-6 flex items-center justify-center">
                        {{-- Mic Active Icon --}}
                        <svg id="icon-mic-on" class="w-5 h-5 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        {{-- Mic Muted Icon --}}
                        <svg id="icon-mic-off" class="w-5 h-5 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                        </svg>
                    </span>
                    <span id="label-mic" class="text-[11px] font-semibold text-slate-300">Mute</span>
                </button>

                {{-- Toggle Video / Camera --}}
                <button id="btn-toggle-cam" wire:ignore
                    class="flex flex-col items-center gap-1.5 p-2.5 sm:px-5 sm:py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all shadow-md group">
                    <span class="w-6 h-6 flex items-center justify-center">
                        {{-- Camera On Icon --}}
                        <svg id="icon-cam-on" class="w-5 h-5 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        {{-- Camera Off Icon --}}
                        <svg id="icon-cam-off" class="w-5 h-5 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </span>
                    <span id="label-cam" class="text-[11px] font-semibold text-slate-300">Stop Video</span>
                </button>

                {{-- Screen Share (Optional/Bonus) --}}
                <button id="btn-toggle-screen" wire:ignore
                    class="hidden sm:flex flex-col items-center gap-1.5 p-2.5 sm:px-5 sm:py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all shadow-md group">
                    <span class="w-6 h-6 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span id="label-screen" class="text-[11px] font-semibold text-slate-300">Share Screen</span>
                </button>

                {{-- Manage / Add Participants (Host/Admin Only) --}}
                @if($isHost)
                    <button wire:click="openParticipantsModal" type="button"
                        class="flex flex-col items-center gap-1.5 p-3 sm:px-5 sm:py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all shadow-md group cursor-pointer"
                        title="Manage / Add Participants">
                        <span class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-300 group-hover:text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        <span class="text-[11px] text-slate-300 group-hover:text-white">Add Users</span>
                    </button>
                @endif

                {{-- Leave / Disconnect Button (Attendees) --}}
                <button id="btn-leave-call"
                    class="flex flex-col items-center gap-1.5 p-3 sm:px-5 sm:py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all shadow-md group cursor-pointer">
                    <span class="w-6 h-6 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </span>
                    <span class="text-[11px] text-slate-300">Leave Call</span>
                </button>

                {{-- End Live Session for All (Host/Admin Only) --}}
                @if($isHost)
                    <button id="btn-end-session" type="button"
                        class="flex flex-col items-center gap-1.5 p-3 sm:px-6 sm:py-3 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-black text-xs transition-all shadow-lg hover:shadow-red-500/30 cursor-pointer">
                        <span class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                            </svg>
                        </span>
                        <span class="text-[11px]">End Session</span>
                    </button>
                @endif

            </div>
        </footer>
    @endif

    {{-- Participants Management Modal (Host / Admin Only) --}}
    @if($isHost && $showParticipantsModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
            style="background:rgba(2,6,23,0.85); backdrop-filter:blur(12px);"
            wire:keydown.escape="closeParticipantsModal">
            
            {{-- Backdrop --}}
            <div class="fixed inset-0" wire:click="closeParticipantsModal"></div>

            {{-- Modal Panel --}}
            <div class="relative bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] z-10 fp-animate-in">
                
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#39E554]/15 border border-[#39E554]/30 flex items-center justify-center text-[#39E554]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white flex items-center gap-2">
                                <span>Session Participants</span>
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#39E554]/20 text-[#39E554] border border-[#39E554]/30">
                                    {{ count($bookedUserIds) }} Added
                                </span>
                            </h3>
                            <p class="text-xs text-slate-400">Search and add registered users individually during the live call.</p>
                        </div>
                    </div>

                    <button wire:click="closeParticipantsModal" type="button"
                        class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Feedback Toast / Alert inside modal --}}
                @if($feedbackMessage)
                    <div class="mx-6 mt-4 p-3.5 rounded-2xl text-xs font-semibold flex items-center justify-between {{ $feedbackType === 'error' ? 'bg-red-500/15 border border-red-500/30 text-red-300' : ($feedbackType === 'info' ? 'bg-blue-500/15 border border-blue-500/30 text-blue-300' : 'bg-[#39E554]/15 border border-[#39E554]/30 text-[#39E554]') }}">
                        <div class="flex items-center gap-2">
                            <span>{{ $feedbackType === 'error' ? '⚠️' : ($feedbackType === 'info' ? 'ℹ️' : '✓') }}</span>
                            <span>{{ $feedbackMessage }}</span>
                        </div>
                        <button wire:click="$set('feedbackMessage', null)" class="text-slate-400 hover:text-white text-xs cursor-pointer">✕</button>
                    </div>
                @endif

                {{-- Search & Tab Toolbar --}}
                <div class="p-6 space-y-4">
                    {{-- Search Input --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text"
                            wire:model.live.debounce.250ms="searchUser"
                            placeholder="Search registered user by name or email..."
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-950/80 border border-slate-800 rounded-2xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-[#39E554] focus:ring-1 focus:ring-[#39E554] transition-all">
                        @if($searchUser !== '')
                            <button wire:click="$set('searchUser', '')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white text-xs cursor-pointer">
                                ✕
                            </button>
                        @endif
                    </div>

                    {{-- Tabs: All Registered Users vs Current Booked --}}
                    <div class="flex items-center gap-2 border-b border-slate-800 pb-2">
                        <button wire:click="setParticipantTab('all')" type="button"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $participantTab === 'all' ? 'bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30' : 'text-slate-400 hover:text-slate-200' }}">
                            👥 Registered Users
                        </button>
                        <button wire:click="setParticipantTab('booked')" type="button"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $participantTab === 'booked' ? 'bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30' : 'text-slate-400 hover:text-slate-200' }}">
                            ✓ Current In-Session ({{ count($bookedUserIds) }})
                        </button>
                    </div>
                </div>

                {{-- User List Body (Scrollable) --}}
                <div class="px-6 pb-6 overflow-y-auto flex-1 space-y-2.5 divide-y divide-slate-800/40">
                    @if($participantTab === 'all')
                        @forelse($registeredUsers as $regUser)
                            @php
                                $isAlreadyAdded = in_array($regUser->id, $bookedUserIds);
                                $userRole = $regUser->roles->first()?->name ?? 'Learner';
                            @endphp
                            <div class="pt-2.5 first:pt-0 flex items-center justify-between gap-3 p-3 rounded-2xl hover:bg-slate-800/40 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#28a04a] to-[#39E554] flex items-center justify-center text-slate-950 font-black text-sm shrink-0 shadow">
                                        {{ strtoupper(substr($regUser->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-bold text-white truncate">{{ $regUser->name }}</p>
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $userRole === 'Admin' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : ($userRole === 'Instructor' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700') }}">
                                                {{ $userRole }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-400 truncate">{{ $regUser->email }}</p>
                                    </div>
                                </div>

                                <div class="shrink-0 flex items-center gap-2">
                                    @if($isAlreadyAdded)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-800 text-[#39E554] border border-[#39E554]/30 text-xs font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Added</span>
                                        </span>
                                    @else
                                        <button wire:click="addParticipant({{ $regUser->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="addParticipant({{ $regUser->id }})"
                                            type="button"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-slate-950 font-extrabold text-xs shadow transition-all hover:scale-105 cursor-pointer disabled:opacity-50"
                                            style="background:linear-gradient(135deg,#39E554,#28a04a);">
                                            <span wire:loading.remove wire:target="addParticipant({{ $regUser->id }})">+ Add</span>
                                            <span wire:loading wire:target="addParticipant({{ $regUser->id }})">Adding...</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-500 space-y-1">
                                <p class="text-sm font-semibold">No registered users found</p>
                                <p class="text-xs">Try adjusting your search query</p>
                            </div>
                        @endforelse
                    @else
                        {{-- Booked / In-session Participants tab --}}
                        @forelse($currentBookings as $bk)
                            <div class="pt-2.5 first:pt-0 flex items-center justify-between gap-3 p-3 rounded-2xl hover:bg-slate-800/40 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-200 font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($bk->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-bold text-white truncate">{{ $bk->user->name ?? 'User' }}</p>
                                            @if($bk->attended)
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#39E554]/20 text-[#39E554] border border-[#39E554]/30">In Call</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400 truncate">{{ $bk->user->email ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="shrink-0 flex items-center gap-2">
                                    <button wire:click="removeParticipant({{ $bk->id }})"
                                        wire:confirm="Remove this participant from the live session?"
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-semibold transition-colors cursor-pointer"
                                        title="Remove Participant">
                                        ✕ Remove
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-500 space-y-1">
                                <p class="text-sm font-semibold">No participants added yet</p>
                                <p class="text-xs">Switch to the "Registered Users" tab above to add users to this session.</p>
                            </div>
                        @endforelse
                    @endif
                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-3.5 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between text-xs text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#39E554]"></span>
                        <span>Added users can join instantly with direct token access.</span>
                    </span>
                    <button wire:click="closeParticipantsModal" type="button"
                        class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold transition-colors cursor-pointer">
                        Done
                    </button>
                </div>

            </div>
        </div>
    @endif

    @if(! $isEnded && ($isJoinable || $isHost))
    <div wire:ignore>
        {{-- Agora Web SDK: Local primary (zero external network dependency) with CDN fallback --}}
        <script src="{{ asset('js/agora-rtc-sdk.js') }}"></script>
        <script>
            if (typeof AgoraRTC === 'undefined') {
                document.write('<script src="https://cdn.jsdelivr.net/npm/agora-rtc-sdk-ng@4.24.1/AgoraRTC_N-production.js"><\/script>');
            }
        </script>
        <script>
            if (typeof AgoraRTC === 'undefined') {
                document.write('<script src="https://unpkg.com/agora-rtc-sdk-ng@4.24.1/AgoraRTC_N-production.js"><\/script>');
            }
        </script>
        <script>
        (function() {
            if (window.__finpulseAgoraActive) {
                return;
            }

            async function waitForAgora(maxWaitMs = 5000) {
                const startTime = Date.now();
                while (typeof AgoraRTC === 'undefined') {
                    if (Date.now() - startTime > maxWaitMs) {
                        return false;
                    }
                    await new Promise(r => setTimeout(r, 100));
                }
                return true;
            }

            async function startAgoraCall() {
                if (window.__finpulseAgoraActive && window.__finpulseAgoraClient) return;
                window.__finpulseAgoraActive = true;

                const agoraConfig = {
                    appId: @json($appId),
                    channelName: @json($channelName),
                    token: @json($agoraToken),
                    uid: @json($uid),
                    isHost: @json($isHost),
                    testingMode: @json($testingMode),
                    exitUrl: @json(route('live-sessions.index')),
                    tokenRefreshUrl: @json(route('live-sessions.token', $session))
                };

                const statusPill = document.getElementById('call-status-pill');
                const localPlayerContainer = document.getElementById('local-player');
                const localAvatarPlaceholder = document.getElementById('local-avatar-placeholder');
                const localMutedBadge = document.getElementById('local-muted-badge');
                const remoteContainer = document.getElementById('remote-playerlist');
                const emptyRoomState = document.getElementById('empty-room-state');
                const permissionToast = document.getElementById('permission-toast');
                const permissionToastMsg = document.getElementById('permission-toast-msg');

                const btnMic = document.getElementById('btn-toggle-mic');
                const iconMicOn = document.getElementById('icon-mic-on');
                const iconMicOff = document.getElementById('icon-mic-off');
                const labelMic = document.getElementById('label-mic');

                const btnCam = document.getElementById('btn-toggle-cam');
                const iconCamOn = document.getElementById('icon-cam-on');
                const iconCamOff = document.getElementById('icon-cam-off');
                const labelCam = document.getElementById('label-cam');

                const btnScreen = document.getElementById('btn-toggle-screen');
                const btnLeave = document.getElementById('btn-leave-call');

                let client = null;
                let localAudioTrack = null;
                let localVideoTrack = null;
                let screenTrack = null;
                let isMuted = false;
                let isCamOff = false;
                let isScreenSharing = false;
                const remoteUsers = {};

                function showToast(message) {
                    if (permissionToast && permissionToastMsg) {
                        permissionToastMsg.innerText = message;
                        permissionToast.classList.remove('hidden');
                    }
                }

                function updateStatus(state, colorClass, text) {
                    if (!statusPill) return;
                    statusPill.className = `inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold ${colorClass}`;
                    statusPill.innerHTML = `<span class="w-2 h-2 rounded-full ${state === 'live' ? 'bg-[#39E554]' : 'bg-amber-400 animate-pulse'}"></span> ${text}`;
                }

                const sdkLoaded = await waitForAgora(5000);
                if (!sdkLoaded || typeof AgoraRTC === 'undefined') {
                    console.error("Agora Web SDK failed to load.");
                    updateStatus('error', 'bg-red-500/20 text-red-300 border border-red-500/30', 'SDK Error');
                    showToast("Could not load Agora Web SDK. Please verify your internet connection.");
                    return;
                }

            try {
                // Initialize Agora RTC Client
                client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
                window.__finpulseAgoraClient = client;

                // Event: Remote user published audio/video
                client.on("user-published", async (user, mediaType) => {
                    await client.subscribe(user, mediaType);
                    remoteUsers[user.uid] = user;

                    if (emptyRoomState) {
                        emptyRoomState.style.display = 'none';
                    }

                    let userWrapper = document.getElementById(`remote-wrapper-${user.uid}`);
                    if (!userWrapper) {
                        userWrapper = document.createElement('div');
                        userWrapper.id = `remote-wrapper-${user.uid}`;
                        userWrapper.className = "relative bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl flex flex-col justify-center items-center min-h-[320px] sm:min-h-[420px] w-full";
                        
                        const remotePlayer = document.createElement('div');
                        remotePlayer.id = `remote-player-${user.uid}`;
                        remotePlayer.className = "absolute inset-0 w-full h-full object-cover";
                        userWrapper.appendChild(remotePlayer);

                        const badge = document.createElement('div');
                        badge.className = "absolute bottom-4 left-4 z-20 flex items-center gap-2 bg-slate-950/70 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-800/80 text-xs font-bold text-white shadow-lg";
                        badge.innerHTML = `<span class="w-2 h-2 rounded-full bg-[#39E554]"></span><span>Participant #${user.uid}</span>`;
                        userWrapper.appendChild(badge);

                        remoteContainer.appendChild(userWrapper);
                    }

                    if (mediaType === "video") {
                        user.videoTrack.play(`remote-player-${user.uid}`);
                    }
                    if (mediaType === "audio") {
                        user.audioTrack.play();
                    }
                });

                // Event: Remote user unpublished track
                client.on("user-unpublished", (user, mediaType) => {
                    if (mediaType === "video") {
                        const player = document.getElementById(`remote-player-${user.uid}`);
                        if (player) player.innerHTML = '';
                    }
                });

                // Event: Remote user left
                client.on("user-left", (user) => {
                    delete remoteUsers[user.uid];
                    const wrapper = document.getElementById(`remote-wrapper-${user.uid}`);
                    if (wrapper) wrapper.remove();

                    if (Object.keys(remoteUsers).length === 0 && emptyRoomState) {
                        emptyRoomState.style.display = 'flex';
                    }
                });

                // Event: Token privilege will expire in 30 seconds -> auto-refresh
                client.on("token-privilege-will-expire", async () => {
                    console.log("Agora token expiring soon, requesting renewed token...");
                    try {
                        const resp = await fetch(agoraConfig.tokenRefreshUrl, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await resp.json();
                        if (data.token) {
                            await client.renewToken(data.token);
                            console.log("Agora token renewed successfully.");
                        }
                    } catch (e) {
                        console.error("Token renewal failed", e);
                    }
                });

                // Join the channel
                await client.join(
                    agoraConfig.appId,
                    agoraConfig.channelName,
                    agoraConfig.token || null,
                    agoraConfig.uid
                );

                updateStatus('live', 'bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30', 'Connected Live');

                // Acquire local microphone and camera
                try {
                    [localAudioTrack, localVideoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks(
                        { AEC: true, ANS: true },
                        { encoderConfig: "720p_1" }
                    );

                    if (localVideoTrack && localPlayerContainer) {
                        localVideoTrack.play("local-player");
                    }

                    // Publish tracks
                    await client.publish([localAudioTrack, localVideoTrack]);
                } catch (mediaError) {
                    console.warn("Could not acquire both audio and camera, trying audio only:", mediaError);
                    showToast("Camera access restricted or not detected. Trying audio only...");

                    try {
                        localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                        await client.publish([localAudioTrack]);
                        if (localAvatarPlaceholder) localAvatarPlaceholder.classList.remove('hidden');
                        if (localPlayerContainer) localPlayerContainer.classList.add('hidden');
                    } catch (audioError) {
                        console.error("Could not acquire microphone track:", audioError);
                        showToast("Microphone and camera permissions denied. You are joined in listen-only mode.");
                    }
                }

            } catch (joinError) {
                console.error("Agora join failed:", joinError);
                updateStatus('error', 'bg-red-500/20 text-red-300 border border-red-500/30', 'Join Failed');
                showToast("Failed to join live session room: " + (joinError.message || joinError));
            }

            // Controls: Mute/Unmute Mic
            if (btnMic) {
                btnMic.addEventListener('click', async () => {
                    if (!localAudioTrack) return;
                    isMuted = !isMuted;
                    await localAudioTrack.setEnabled(!isMuted);

                    if (isMuted) {
                        iconMicOn.classList.add('hidden');
                        iconMicOff.classList.remove('hidden');
                        labelMic.innerText = 'Unmute';
                        labelMic.classList.add('text-red-400');
                        if (localMutedBadge) localMutedBadge.classList.remove('hidden');
                    } else {
                        iconMicOn.classList.remove('hidden');
                        iconMicOff.classList.add('hidden');
                        labelMic.innerText = 'Mute';
                        labelMic.classList.remove('text-red-400');
                        if (localMutedBadge) localMutedBadge.classList.add('hidden');
                    }
                });
            }

            // Controls: Camera On/Off
            if (btnCam) {
                btnCam.addEventListener('click', async () => {
                    if (!localVideoTrack) return;
                    isCamOff = !isCamOff;
                    await localVideoTrack.setEnabled(!isCamOff);

                    if (isCamOff) {
                        iconCamOn.classList.add('hidden');
                        iconCamOff.classList.remove('hidden');
                        labelCam.innerText = 'Start Video';
                        labelCam.classList.add('text-red-400');
                        if (localPlayerContainer) localPlayerContainer.classList.add('hidden');
                        if (localAvatarPlaceholder) localAvatarPlaceholder.classList.remove('hidden');
                    } else {
                        iconCamOn.classList.remove('hidden');
                        iconCamOff.classList.add('hidden');
                        labelCam.innerText = 'Stop Video';
                        labelCam.classList.remove('text-red-400');
                        if (localPlayerContainer) localPlayerContainer.classList.remove('hidden');
                        if (localAvatarPlaceholder) localAvatarPlaceholder.classList.add('hidden');
                    }
                });
            }

            // Controls: Screen Share
            if (btnScreen) {
                btnScreen.addEventListener('click', async () => {
                    if (!client) return;
                    try {
                        if (!isScreenSharing) {
                            screenTrack = await AgoraRTC.createScreenVideoTrack();
                            if (localVideoTrack) {
                                await client.unpublish(localVideoTrack);
                            }
                            await client.publish(screenTrack);
                            screenTrack.play("local-player");
                            isScreenSharing = true;
                            document.getElementById('label-screen').innerText = 'Stop Share';

                            screenTrack.on('track-ended', async () => {
                                await client.unpublish(screenTrack);
                                screenTrack.close();
                                if (localVideoTrack) {
                                    await client.publish(localVideoTrack);
                                    localVideoTrack.play("local-player");
                                }
                                isScreenSharing = false;
                                document.getElementById('label-screen').innerText = 'Share Screen';
                            });
                        } else {
                            if (screenTrack) {
                                await client.unpublish(screenTrack);
                                screenTrack.close();
                            }
                            if (localVideoTrack) {
                                await client.publish(localVideoTrack);
                                localVideoTrack.play("local-player");
                            }
                            isScreenSharing = false;
                            document.getElementById('label-screen').innerText = 'Share Screen';
                        }
                    } catch (e) {
                        console.warn("Screen share cancelled or unsupported", e);
                    }
                });
            }

            // Controls: Leave Call
            async function leaveSession() {
                try {
                    if (localAudioTrack) {
                        localAudioTrack.stop();
                        localAudioTrack.close();
                    }
                    if (localVideoTrack) {
                        localVideoTrack.stop();
                        localVideoTrack.close();
                    }
                    if (screenTrack) {
                        screenTrack.stop();
                        screenTrack.close();
                    }
                    if (client) {
                        await client.leave();
                    }
                } catch (e) {
                    console.error("Error during leave:", e);
                } finally {
                    window.__finpulseAgoraActive = false;
                    window.__finpulseAgoraClient = null;
                    window.location.href = agoraConfig.exitUrl;
                }
            }

            if (btnLeave) {
                btnLeave.addEventListener('click', leaveSession);
            }

            // Controls: End Session for All (Host / Admin)
            async function endSessionForEveryone() {
                if (!confirm('Are you sure you want to end this live session for all participants?')) {
                    return;
                }
                try {
                    if (localAudioTrack) {
                        localAudioTrack.stop();
                        localAudioTrack.close();
                    }
                    if (localVideoTrack) {
                        localVideoTrack.stop();
                        localVideoTrack.close();
                    }
                    if (screenTrack) {
                        screenTrack.stop();
                        screenTrack.close();
                    }
                    if (client) {
                        await client.leave();
                    }
                } catch (e) {
                    console.error("Error leaving Agora before ending session:", e);
                } finally {
                    window.__finpulseAgoraActive = false;
                    window.__finpulseAgoraClient = null;
                }

                // Call Livewire component method
                if (window.Livewire) {
                    const compEl = document.querySelector('[wire\\:id]');
                    if (compEl) {
                        const lw = Livewire.find(compEl.getAttribute('wire:id'));
                        if (lw && lw.endSession) {
                            lw.endSession();
                            return;
                        }
                    }
                }
                window.location.href = agoraConfig.exitUrl;
            }

            const btnEndSession = document.getElementById('btn-end-session');
            const btnEndSessionHeader = document.getElementById('btn-end-session-header');

            if (btnEndSession) {
                btnEndSession.addEventListener('click', endSessionForEveryone);
            }
            if (btnEndSessionHeader) {
                btnEndSessionHeader.addEventListener('click', endSessionForEveryone);
            }

            window.addEventListener('session-ended', async () => {
                window.__finpulseAgoraActive = false;
                window.__finpulseAgoraClient = null;
                try {
                    if (localAudioTrack) { localAudioTrack.stop(); localAudioTrack.close(); }
                    if (localVideoTrack) { localVideoTrack.stop(); localVideoTrack.close(); }
                    if (screenTrack) { screenTrack.stop(); screenTrack.close(); }
                    if (client) { await client.leave(); }
                } catch (e) {
                    console.error("Error leaving channel after session ended:", e);
                }
                updateStatus('offline', 'bg-red-500/20 text-red-300 border border-red-500/30', 'Session Ended');
            });

            window.addEventListener('beforeunload', () => {
                window.__finpulseAgoraActive = false;
                window.__finpulseAgoraClient = null;
                if (client) client.leave();
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', startAgoraCall);
        } else {
            startAgoraCall();
        }

        document.addEventListener('livewire:navigated', () => {
            if (document.getElementById('call-status-pill') && !window.__finpulseAgoraActive) {
                startAgoraCall();
            }
        });
    })();
    </script>
    </div>
    @endif

</div>
