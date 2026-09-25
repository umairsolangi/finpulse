<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-6 fp-animate-in">
    <!-- Breadcrumb -->
    <div>
        <a
            href="{{ route('live-sessions.index') }}"
            wire:navigate
            class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-finpulse-navy hover:text-[#39E554] transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Back to Live Sessions</span>
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 sm:p-8 space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h1 class="text-2xl font-extrabold text-finpulse-navy">Schedule a Live Session</h1>
            <p class="text-xs text-gray-500 mt-1">Host an interactive webinar or 1-on-1 portfolio review session with community members.</p>
        </div>

        <form wire:submit="save" class="space-y-6">
            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                    Session Title <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    placeholder="e.g. Q3 KSE-100 Earnings Review & Sector Analysis"
                    class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                />
                @error('title') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                    Description & Agenda <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="4"
                    placeholder="Provide detailed agenda, key topics, and prerequisites for attendees..."
                    class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                ></textarea>
                @error('description') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Grid 2-col -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Session Type -->
                <div class="space-y-1.5">
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        Session Format <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="type"
                        wire:model.live="type"
                        class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                    >
                        <option value="webinar">Group Webinar</option>
                        <option value="one_on_one">1-on-1 Mentoring Slot</option>
                    </select>
                    @error('type') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Access Tier -->
                <div class="space-y-1.5">
                    <label for="tier" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        Audience Tier <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="tier"
                        wire:model="tier"
                        class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                    >
                        <option value="paid">Paid Subscriber Exclusive</option>
                        <option value="free">Free for All Community Members</option>
                        <option value="registered">Registered Members Only</option>
                    </select>
                    @error('tier') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Launch Mode Selector -->
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                    Launch Timing <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <button
                        type="button"
                        wire:click="$set('is_instant', false)"
                        class="p-4 rounded-2xl border text-left transition-all flex items-start gap-3 {{ !$is_instant ? 'border-[#28a04a] bg-emerald-50/50 ring-2 ring-[#28a04a]/30' : 'border-gray-200 hover:border-gray-300 bg-white' }}"
                    >
                        <span class="text-xl">📅</span>
                        <div>
                            <div class="text-xs font-bold text-slate-900">Schedule for Future</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">Pick a future date & time. Attendees can reserve seats ahead of time.</div>
                        </div>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('is_instant', true)"
                        class="p-4 rounded-2xl border text-left transition-all flex items-start gap-3 {{ $is_instant ? 'border-red-500 bg-red-50/50 ring-2 ring-red-500/30' : 'border-gray-200 hover:border-gray-300 bg-white' }}"
                    >
                        <span class="text-xl">⚡</span>
                        <div>
                            <div class="text-xs font-bold text-red-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                Start Instant Session (Go Live Now)
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">Provisions room right now and takes you straight into the live call.</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Date, Duration, Capacity -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Scheduled At (Or Instant Badge) -->
                <div class="space-y-1.5 sm:col-span-1">
                    <label for="scheduled_at" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        {{ $is_instant ? 'Start Time' : 'Date & Time' }} <span class="text-red-500">*</span>
                    </label>
                    @if($is_instant)
                        <div class="h-[42px] px-3.5 rounded-xl bg-red-50 border border-red-200 flex items-center gap-2 text-xs font-bold text-red-700">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            <span>Immediate (Starts Now)</span>
                        </div>
                    @else
                        <input
                            type="datetime-local"
                            id="scheduled_at"
                            wire:model="scheduled_at"
                            class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                        />
                        @error('scheduled_at') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                    @endif
                </div>

                <!-- Duration -->
                <div class="space-y-1.5">
                    <label for="duration_minutes" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        Duration (Minutes) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="duration_minutes"
                        wire:model="duration_minutes"
                        min="15"
                        max="240"
                        step="15"
                        class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                    />
                    @error('duration_minutes') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Max Attendees -->
                <div class="space-y-1.5">
                    <label for="max_attendees" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        Max Attendees
                    </label>
                    <input
                        type="number"
                        id="max_attendees"
                        wire:model="max_attendees"
                        min="1"
                        max="500"
                        {{ $type === 'one_on_one' ? 'disabled' : '' }}
                        class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm {{ $type === 'one_on_one' ? 'bg-gray-100' : '' }}"
                    />
                    @error('max_attendees') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Agora Native Room Auto-Generation Banner -->
            <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-slate-900 to-slate-800 border border-slate-700/80 text-white space-y-3 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-[#39E554] animate-pulse"></span>
                        <span class="text-xs font-black uppercase tracking-wider text-[#39E554]">
                            Built-in Agora Video Call Room
                        </span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#39E554]/15 text-[#39E554] border border-[#39E554]/30">
                        Auto-Generated
                    </span>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    FinPulse automatically provisions a secure, high-performance Agora RTC live channel for this session. No third-party software, meeting links, or external credentials required — you and booked attendees will join directly inside FinPulse with audio, video, and screen sharing.
                </p>

                <!-- Optional External Meeting URL Accordion (only if instructor wants external Zoom/Meet) -->
                <div x-data="{ showExternal: false }" class="pt-2 border-t border-slate-700/60">
                    <button type="button" @click="showExternal = !showExternal" class="text-[11px] text-slate-400 hover:text-white flex items-center gap-1 font-semibold transition-colors">
                        <svg class="w-3.5 h-3.5 transition-transform" :class="{ 'rotate-90': showExternal }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span>Need to use an external meeting link instead? (Optional Zoom / Google Meet)</span>
                    </button>
                    <div x-show="showExternal" x-cloak class="mt-3 space-y-1.5">
                        <input
                            type="url"
                            id="meeting_url"
                            wire:model="meeting_url"
                            placeholder="https://meet.google.com/xyz-abcd-efg or https://zoom.us/j/..."
                            class="w-full rounded-xl bg-slate-950 border-slate-700 text-white placeholder-slate-500 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 text-xs"
                        />
                        <p class="text-[10px] text-slate-400">Leave blank to use FinPulse's native Agora video room.</p>
                        @error('meeting_url') <span class="text-xs text-red-400 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                <a
                    href="{{ route('live-sessions.index') }}"
                    wire:navigate
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 rounded-xl text-white font-bold text-sm shadow-md transition-all flex items-center gap-2 {{ $is_instant ? 'bg-red-600 hover:bg-red-500 shadow-red-500/20' : 'bg-finpulse-navy hover:bg-slate-800' }}"
                >
                    <span wire:loading.remove wire:target="save">
                        {{ $is_instant ? '🔴 Launch Live Session Now' : 'Publish Live Session' }}
                    </span>
                    <span wire:loading wire:target="save">
                        {{ $is_instant ? 'Launching Agora Room...' : 'Scheduling...' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
