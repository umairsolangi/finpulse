<div class="relative" x-data="{ open: @entangle('open') }" @click.outside="open = false" wire:poll.60s>
    {{-- Bell Icon Trigger --}}
    <button @click="open = !open" type="button"
        class="relative p-2 rounded-xl text-gray-500 hover:text-[#0B1A33] hover:bg-gray-100 focus:outline-none transition-colors"
        aria-label="Notifications">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown Flyout --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200/80 z-50 overflow-hidden"
        style="display: none;">

        {{-- Dropdown Header --}}
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/70">
            <div class="flex items-center gap-2">
                <span class="font-bold text-sm text-[#0B1A33]">Notifications</span>
                @if($unreadCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-bold bg-[#0B1A33] text-[#C89B3C] rounded-full">
                        {{ $unreadCount }} new
                    </span>
                @endif
            </div>

            @if($unreadCount > 0)
                <button wire:click="markAllAsRead"
                    class="text-xs font-semibold text-[#0B1A33] hover:text-[#C89B3C] transition-colors">
                    Mark all as read
                </button>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="max-h-96 overflow-y-auto divide-y divide-gray-100">
            @forelse($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $data = $notification->data;
                    $type = $data['type'] ?? 'general';
                    $title = $data['title'] ?? ($data['chapter_title'] ?? ($data['message'] ?? 'Notification'));
                    $timeAgo = $notification->created_at->diffForHumans(short: true);
                @endphp
                <div wire:click="markAsRead('{{ $notification->id }}')"
                    class="p-4 flex items-start gap-3 hover:bg-gray-50 cursor-pointer transition-colors {{ $isUnread ? 'bg-amber-50/40' : '' }}">
                    
                    {{-- Icon --}}
                    <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $type === 'new_chapter' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                        @if($type === 'new_chapter')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline justify-between gap-1 mb-1">
                            <p class="text-xs font-bold text-[#0B1A33] truncate">
                                {{ $title }}
                            </p>
                            <span class="text-[10px] text-gray-400 shrink-0">{{ $timeAgo }}</span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                            {{ $data['message'] ?? ($data['excerpt'] ?? '') }}
                        </p>
                    </div>

                    {{-- Unread Dot --}}
                    @if($isUnread)
                        <span class="w-2 h-2 rounded-full bg-[#C89B3C] shrink-0 self-center"></span>
                    @endif
                </div>
            @empty
                <div class="py-10 text-center px-4">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-xs font-semibold text-gray-600">No notifications yet</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">We'll alert you when new chapters and market reports drop.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
