<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Admin Top Bar & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-red-100 text-red-800 border border-red-200">
                    Admin Portal
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-finpulse-navy mt-1">Role Audit Trail</h1>
            <p class="text-xs text-gray-500">Immutable record of all role assignments and revocations across FinPulse.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a
                href="{{ route('admin.users.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Users List
            </a>
            <a
                href="{{ route('admin.roles.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Role Matrix
            </a>
            <a
                href="{{ route('admin.settings.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Settings
            </a>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200/90 p-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-1 flex-col sm:flex-row items-center gap-3 w-full">
            <div class="relative flex-1 w-full">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="targetFilter"
                    placeholder="Filter by target user (name or email)..."
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-lg border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <div class="relative flex-1 w-full">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="actorFilter"
                    placeholder="Filter by admin / actor (name or email)..."
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-lg border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

            @if($targetFilter || $actorFilter)
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="px-3 py-2 text-xs font-semibold text-gray-600 hover:text-finpulse-navy hover:bg-gray-100 rounded-lg transition-colors shrink-0"
                >
                    Clear Filters
                </button>
            @endif
        </div>

        <div class="text-xs text-gray-500 font-medium shrink-0">
            Total records: <span class="font-bold text-gray-900">{{ $logs->total() }}</span>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead class="bg-gray-50 text-gray-600 font-semibold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4 text-left">Date & Time</th>
                        <th class="py-3 px-4 text-left">Target User</th>
                        <th class="py-3 px-4 text-left">Action</th>
                        <th class="py-3 px-4 text-left">Role</th>
                        <th class="py-3 px-4 text-left">Changed By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($logs as $log)
                        @php
                            $isAssigned = $log->action->value === 'assigned';
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-600">
                                <div class="font-semibold text-finpulse-navy">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-[11px] text-gray-400">{{ $log->created_at->format('h:i:s A') }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($log->targetUser)
                                    <a
                                        href="{{ route('admin.users.show', $log->targetUser->id) }}"
                                        wire:navigate
                                        class="group block"
                                    >
                                        <div class="font-bold text-finpulse-navy group-hover:text-[#C89B3C] transition-colors">
                                            {{ $log->targetUser->name }}
                                        </div>
                                        <div class="text-[11px] text-gray-500">
                                            {{ $log->targetUser->email }}
                                        </div>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Deleted User #{{ $log->target_user_id }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $isAssigned ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-rose-50 text-rose-800 border-rose-300' }}">
                                    @if($isAssigned)
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Assigned
                                    @else
                                        <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                        Removed
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-finpulse-navy">
                                {{ $log->role }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($log->changedByUser)
                                    <div class="font-semibold text-gray-800">{{ $log->changedByUser->name }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $log->changedByUser->email }}</div>
                                @else
                                    <span class="text-gray-500 italic">System / Seeder</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 text-xs">
                                No role changes recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
