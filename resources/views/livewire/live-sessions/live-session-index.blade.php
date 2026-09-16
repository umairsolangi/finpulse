<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-gray-200 fp-animate-in">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-300">
                    🎙️ Interactive Learning
                </span>
            </div>
            <h1 class="text-3xl font-extrabold text-finpulse-navy tracking-tight">
                Live Sessions & Market Webinars
            </h1>
            <p class="text-sm text-finpulse-gray max-w-2xl">
                Attend interactive market briefings, Q&A sessions with certified financial analysts, and one-on-one portfolio clinics.
            </p>
        </div>

        @if($isInstructorOrAdmin)
            <div class="shrink-0">
                <a
                    href="{{ route('live-sessions.create') }}"
                    wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-finpulse-navy hover:bg-slate-800 text-white font-bold text-sm shadow-sm hover:shadow transition-all"
                >
                    <svg class="w-4 h-4 text-[#C89B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Schedule Live Session</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Alert Banners -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium fp-animate-in">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-xl text-sm font-medium fp-animate-in">
            {{ session('warning') }}
        </div>
    @endif
    @if(session('info'))
        <div class="p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl text-sm font-medium fp-animate-in">
            {{ session('info') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium fp-animate-in">
            {{ session('error') }}
        </div>
    @endif

    <!-- Sessions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($sessions as $session)
            @php
                $isBooked = $userBookings->has($session->id);
                $booking = $isBooked ? $userBookings->get($session->id) : null;
                $isPaid = ($session->tier?->value ?? $session->tier) === 'paid';
                $isJoinable = $session->isJoinable();
                $isFull = $session->isFull();
            @endphp
            <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden {{ $isBooked ? 'ring-2 ring-emerald-500/50' : '' }}">
                <div class="p-6 space-y-4">
                    <!-- Badges -->
                    <div class="flex items-center justify-between gap-2 flex-wrap text-xs">
                        <span class="px-2.5 py-1 rounded-md font-bold uppercase tracking-wider {{ $session->type === 'webinar' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                            {{ $session->type === 'webinar' ? '📡 Group Webinar' : '👤 1-on-1 Mentoring' }}
                        </span>

                        @if($isPaid)
                            <span class="px-2.5 py-1 rounded-md font-bold uppercase tracking-wider bg-amber-50 text-[#C89B3C] border border-[#C89B3C]/30">
                                Paid Tier
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-md font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Free
                            </span>
                        @endif
                    </div>

                    <!-- Title & Details -->
                    <div>
                        <h3 class="font-bold text-lg text-finpulse-navy leading-snug">
                            {{ $session->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed">
                            {{ $session->description }}
                        </p>
                    </div>

                    <!-- Schedule & Host Info -->
                    <div class="space-y-2 pt-2 border-t border-gray-100 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#C89B3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-semibold text-finpulse-navy">{{ $session->scheduled_at->format('D, M d, Y — h:i A') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $session->duration_minutes }} minutes</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Host: <strong>{{ $session->host->name ?? 'Instructor' }}</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Area -->
                <div class="p-5 bg-gray-50/90 border-t border-gray-100 space-y-2">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="w-full block text-center py-2.5 px-4 rounded-xl bg-finpulse-navy text-white font-bold text-xs hover:bg-slate-800 transition-colors shadow-sm"
                        >
                            Log in to Book Session
                        </a>
                    @else
                        @if($isBooked)
                            <div class="space-y-2 text-center">
                                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Seat Reserved
                                </div>

                                @if($isJoinable && $session->meeting_url)
                                    <a
                                        href="{{ $session->meeting_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition-all animate-pulse"
                                    >
                                        <span>Join Live Session Room</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @else
                                    <p class="text-[11px] text-gray-500">
                                        Meeting link activates 10 minutes prior to scheduled start.
                                    </p>
                                @endif

                                <button
                                    wire:click="cancelBooking({{ $booking->id }})"
                                    wire:confirm="Are you sure you want to cancel this booking?"
                                    class="text-[11px] text-red-600 hover:text-red-800 underline font-medium block mx-auto pt-1"
                                >
                                    Cancel Booking
                                </button>
                            </div>
                        @else
                            @if($isFull)
                                <button
                                    disabled
                                    class="w-full py-2.5 px-4 rounded-xl bg-gray-200 text-gray-500 font-semibold text-xs cursor-not-allowed"
                                >
                                    Session Full
                                </button>
                            @elseif(!$isPaid || $hasPaidAccess)
                                <button
                                    wire:click="bookSession({{ $session->id }})"
                                    wire:loading.attr="disabled"
                                    class="w-full py-2.5 px-4 rounded-xl bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-xs shadow-sm transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1.5"
                                >
                                    <span wire:loading.remove wire:target="bookSession({{ $session->id }})">Reserve Seat (Free for Subscriber)</span>
                                    <span wire:loading wire:target="bookSession({{ $session->id }})">Reserving...</span>
                                </button>
                            @else
                                <a
                                    href="{{ route('pricing') }}"
                                    wire:navigate
                                    class="w-full block text-center py-2.5 px-4 rounded-xl bg-finpulse-navy hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition-all"
                                >
                                    Upgrade to Paid to Book
                                </a>
                            @endif
                        @endif
                    @endguest
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-xl text-gray-400">
                    🎙️
                </div>
                <h3 class="text-base font-bold text-finpulse-navy">No upcoming live sessions</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto">Check back regularly or subscribe to our newsletter to be notified when instructors schedule the next live interactive webinars.</p>
            </div>
        @endforelse
    </div>
</div>
