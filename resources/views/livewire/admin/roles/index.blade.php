<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex items-center justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <a
                href="{{ route('admin.users.index') }}"
                wire:navigate
                class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-finpulse-navy hover:text-[#C89B3C] transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to User Directory</span>
            </a>
            <h1 class="text-2xl font-extrabold text-finpulse-navy mt-2">Platform Roles & Permissions Matrix</h1>
            <p class="text-xs text-gray-500">Live, dynamically queried authorization definitions from the Spatie permission registry.</p>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
            @php
                $roleBadgeClass = match($role->name) {
                    'Admin' => 'bg-rose-100 text-rose-900 border-rose-300',
                    'Moderator' => 'bg-amber-100 text-amber-900 border-amber-300',
                    'Instructor' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                    'Paid Subscriber' => 'bg-blue-100 text-blue-900 border-blue-300',
                    default => 'bg-gray-100 text-gray-800 border-gray-300',
                };
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $roleBadgeClass }}">
                            {{ $role->name }}
                        </span>
                        <span class="text-[11px] font-semibold text-gray-400">
                            {{ $role->permissions->count() }} {{ Str::plural('permission', $role->permissions->count()) }}
                        </span>
                    </div>

                    <div class="pt-2">
                        <h4 class="text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-2">Granted Permissions:</h4>
                        @if($role->permissions->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($role->permissions as $perm)
                                    <span class="inline-block px-2 py-0.5 rounded bg-gray-100 text-finpulse-navy font-mono text-[10px] font-semibold">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs italic text-gray-400">No permissions assigned.</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-8 text-center text-gray-500 text-xs border border-gray-200">
                No roles found in database.
            </div>
        @endforelse
    </div>
</div>
