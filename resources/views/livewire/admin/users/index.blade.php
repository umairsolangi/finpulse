<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Admin Top Bar & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-red-100 text-red-800 border border-red-200">
                    Admin Portal
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-finpulse-navy mt-1">User & Role Management</h1>
            <p class="text-xs text-gray-500">View registered users, inspect access levels, and reassign platform roles.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a
                href="{{ route('admin.roles.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Role Permissions Matrix
            </a>
            <a
                href="{{ route('admin.role-changes.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Role Audit Trail
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

    <!-- Search Controls -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200/90 p-4 flex items-center justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search users by name or email..."
                class="w-full pl-10 pr-4 py-2 text-xs rounded-lg border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="text-xs text-gray-500 font-medium">
            Showing {{ $users->total() }} registered {{ Str::plural('user', $users->total()) }}
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead class="bg-gray-50 text-gray-600 font-semibold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4 text-left">User</th>
                        <th class="py-3 px-4 text-left">Role</th>
                        <th class="py-3 px-4 text-left">Subscription</th>
                        <th class="py-3 px-4 text-left">Activity Score</th>
                        <th class="py-3 px-4 text-left">Joined</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                        @php
                            $roleName = $user->getRoleNames()->first() ?? 'Free Member';
                            $roleBadgeClass = match($roleName) {
                                'Admin' => 'bg-rose-100 text-rose-900 border-rose-300',
                                'Moderator' => 'bg-amber-100 text-amber-900 border-amber-300',
                                'Instructor' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                'Paid Subscriber' => 'bg-blue-100 text-blue-900 border-blue-300',
                                default => 'bg-gray-100 text-gray-800 border-gray-300',
                            };

                            $activeSub = $user->subscriptions->first(fn($s) => in_array($s->status, ['active', 'cancelled']) && $s->ends_at->isFuture());
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#0B1A33] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-finpulse-navy truncate">{{ $user->name }}</div>
                                        <div class="text-[11px] text-gray-500 truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $roleBadgeClass }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($activeSub)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active (until {{ $activeSub->ends_at->format('M d') }})
                                    </span>
                                @else
                                    <span class="text-[11px] text-gray-400">Free Tier</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-gray-700">
                                {{ number_format($user->activity_score ?? 0) }} pts
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-right">
                                <a
                                    href="{{ route('admin.users.show', $user->id) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-finpulse-navy bg-gray-100 hover:bg-[#39E554] hover:bg-[#28a04a] transition-all"
                                >
                                    <span>Manage</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 text-xs">
                                No users matched your search criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
