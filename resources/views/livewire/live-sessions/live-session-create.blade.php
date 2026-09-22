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

            <!-- Date, Duration, Capacity -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Scheduled At -->
                <div class="space-y-1.5 sm:col-span-1">
                    <label for="scheduled_at" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                        Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="scheduled_at"
                        wire:model="scheduled_at"
                        class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                    />
                    @error('scheduled_at') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
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

            <!-- Meeting URL -->
            <div class="space-y-1.5">
                <label for="meeting_url" class="block text-xs font-bold uppercase tracking-wider text-finpulse-navy">
                    Meeting URL (Agora Room / Zoom / Google Meet) <span class="text-red-500">*</span>
                </label>
                <input
                    type="url"
                    id="meeting_url"
                    wire:model="meeting_url"
                    placeholder="https://meet.google.com/xyz-abcd-efg or https://agora.io/..."
                    class="w-full rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20 text-sm"
                />
                <p class="text-[11px] text-gray-500">
                    This link is protected and only revealed to confirmed booked attendees 10 minutes before the session starts.
                </p>
                @error('meeting_url') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
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
                    class="px-6 py-2.5 rounded-xl bg-finpulse-navy hover:bg-slate-800 text-white font-bold text-sm shadow-md transition-all flex items-center gap-2"
                >
                    <span wire:loading.remove wire:target="save">Publish Live Session</span>
                    <span wire:loading wire:target="save">Scheduling...</span>
                </button>
            </div>
        </form>
    </div>
</div>
