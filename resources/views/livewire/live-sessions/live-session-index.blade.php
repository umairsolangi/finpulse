<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .fp-session-card {
            background:#fff; border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 1px 4px rgba(0,0,0,0.04);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative; overflow: hidden;
        }
        .fp-session-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(57,229,84,0.14); border-color:rgba(57,229,84,0.3); }
        .fp-session-card.booked { box-shadow:0 0 0 2px rgba(57,229,84,0.4), 0 4px 16px rgba(57,229,84,0.12); }
        @keyframes sessionPulse { 0%,100% { box-shadow:0 0 0 2px rgba(57,229,84,0.4); } 50% { box-shadow:0 0 0 4px rgba(57,229,84,0.2); } }
        .fp-join-btn { background:linear-gradient(135deg,#39E554,#28a04a); animation: sessionPulse 2s infinite; }
        .section-label { font-size:0.65rem; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:#28a04a; }
    </style>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 fp-animate-in"
        style="border-bottom:1px solid rgba(226,232,240,0.8);">
        <div class="space-y-2">
            
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                Live Sessions &amp; <span class="bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Market Webinars</span>
            </h1>
            <p class="text-sm text-slate-500 max-w-2xl font-medium leading-relaxed">
                Attend interactive market briefings, Q&amp;A sessions with certified financial analysts, and one-on-one portfolio clinics.
            </p>
        </div>

        @if($isInstructorOrAdmin)
            <div class="shrink-0">
                <a href="{{ route('live-sessions.create') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-slate-950 font-bold text-sm shadow transition-all hover:-translate-y-0.5 hover:shadow-lg"
                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Schedule Live Session
                </a>
            </div>
        @endif
    </div>

    {{-- Alert Banners --}}
    @if(session('success'))
        <div class="p-4 rounded-xl text-sm font-medium fp-animate-in"
            style="background:rgba(57,229,84,0.1); border:1px solid rgba(57,229,84,0.3); color:#28a04a;">
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

    <p class="section-label px-1">Upcoming Sessions</p>

    {{-- Sessions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fp-stagger-grid">
        @forelse($sessions as $session)
            @php
                $isBooked   = $userBookings->has($session->id);
                $booking    = $isBooked ? $userBookings->get($session->id) : null;
                $isPaid     = ($session->tier?->value ?? $session->tier) === 'paid';
                $isJoinable = $session->isJoinable();
                $isFull     = $session->isFull();
            @endphp
            <div class="fp-session-card rounded-2xl flex flex-col justify-between {{ $isBooked ? 'booked' : '' }}">
                <div class="p-6 space-y-4">
                    {{-- Badges --}}
                    <div class="flex items-center justify-between gap-2 flex-wrap text-xs">
                        <span class="px-2.5 py-1 rounded-lg font-bold uppercase tracking-wider
                            {{ $session->type === 'webinar' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                            {{ $session->type === 'webinar' ? '📡 Group Webinar' : '👤 1-on-1 Mentoring' }}
                        </span>
                        @if($isPaid)
                            <span class="px-2.5 py-1 rounded-lg font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                Paid Tier
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg font-bold uppercase tracking-wider"
                                style="background:rgba(57,229,84,0.1); color:#28a04a; border:1px solid rgba(57,229,84,0.25);">
                                Free
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 leading-snug">{{ $session->title }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">{{ $session->description }}</p>
                    </div>

                    {{-- Meta --}}
                    <div class="space-y-2 pt-2 text-xs text-slate-500 font-medium" style="border-top:1px solid #f1f5f9;">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#39E554] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-bold text-slate-700">{{ $session->scheduled_at->format('D, M d, Y — h:i A') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $session->duration_minutes }} minutes</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Host: <strong class="text-slate-700">{{ $session->host->name ?? 'Instructor' }}</strong></span>
                        </div>
                    </div>
                </div>

                {{-- Footer Action --}}
                <div class="p-5 space-y-2" style="background:#f8fafc; border-top:1px solid rgba(226,232,240,0.8);">
                    @guest
                        <a href="{{ route('login') }}" wire:navigate
                            class="w-full block text-center py-2.5 px-4 rounded-xl text-slate-950 font-bold text-xs shadow transition-colors"
                            style="background:linear-gradient(135deg,#39E554,#28a04a);">
                            Log in to Book Session
                        </a>
                    @else
                        @if($isBooked)
                            <div class="space-y-2 text-center">
                                <div class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full"
                                    style="background:rgba(57,229,84,0.12); color:#28a04a; border:1px solid rgba(57,229,84,0.3);">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Seat Reserved
                                </div>
                                @if($isJoinable && $session->meeting_url)
                                    <a href="{{ $session->meeting_url }}" target="_blank" rel="noopener noreferrer"
                                        class="fp-join-btn w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-slate-950 font-extrabold text-xs shadow-md transition-all">
                                        <span>Join Live Session Room</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @else
                                    <p class="text-[11px] text-slate-400 font-medium">Meeting link activates 10 minutes prior to scheduled start.</p>
                                @endif
                                <button wire:click="cancelBooking({{ $booking->id }})"
                                    wire:confirm="Are you sure you want to cancel this booking?"
                                    class="text-[11px] text-red-500 hover:text-red-700 underline font-semibold block mx-auto pt-1 transition-colors">
                                    Cancel Booking
                                </button>
                            </div>
                        @else
                            @if($isFull)
                                <button disabled
                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-100 text-slate-400 font-semibold text-xs cursor-not-allowed">
                                    Session Full
                                </button>
                            @elseif(!$isPaid || $hasPaidAccess)
                                <button wire:click="bookSession({{ $session->id }})"
                                    wire:loading.attr="disabled"
                                    class="w-full py-2.5 px-4 rounded-xl text-slate-950 font-bold text-xs shadow transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1.5"
                                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                                    <span wire:loading.remove wire:target="bookSession({{ $session->id }})">Reserve Seat (Free for Subscriber)</span>
                                    <span wire:loading wire:target="bookSession({{ $session->id }})">Reserving...</span>
                                </button>
                            @else
                                <a href="{{ route('pricing') }}" wire:navigate
                                    class="w-full block text-center py-2.5 px-4 rounded-xl font-bold text-xs shadow transition-all"
                                    style="background:linear-gradient(135deg,#39E554,#28a04a); color:#0F172A;">
                                    Upgrade to Paid to Book
                                </a>
                            @endif
                        @endif
                    @endguest
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center space-y-3"
                style="border:1px solid rgba(226,232,240,0.8);">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto text-2xl"
                    style="background:rgba(57,229,84,0.1);">🎙️</div>
                <h3 class="text-base font-bold text-slate-900">No upcoming live sessions</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto font-medium">Check back regularly or subscribe to our newsletter to be notified when instructors schedule the next live interactive webinars.</p>
            </div>
        @endforelse
    </div>

</div>
