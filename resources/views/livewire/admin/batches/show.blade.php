<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.batches.index') }}" wire:navigate class="text-xs text-gray-400 hover:text-finpulse-navy transition-colors">
                    ← Batches
                </a>
            </div>
            <h1 class="text-2xl font-extrabold text-finpulse-navy">{{ $batch->name }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">
                Course: <span class="font-semibold text-gray-700">{{ $batch->course?->title }}</span>
                &bull;
                Created by <span class="font-semibold">{{ $batch->creator?->name }}</span>
                &bull;
                @php
                    $statusClass = match($batch->status?->value) {
                        'active' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                        'upcoming' => 'bg-amber-100 text-amber-800 border-amber-300',
                        'completed' => 'bg-gray-100 text-gray-700 border-gray-300',
                        default => 'bg-gray-100 text-gray-700 border-gray-300',
                    };
                @endphp
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full border {{ $statusClass }}">
                    {{ $batch->status?->label() }}
                </span>
                @if($batch->start_date)
                    &bull; Starts {{ $batch->start_date->format('d M Y') }}
                @endif
            </p>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800 font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800 font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Confirmation Modal -->
    @if($confirmRemoveUserId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 max-w-sm w-full mx-4 space-y-4">
                <h3 class="text-base font-bold text-finpulse-navy">Remove Student?</h3>
                <p class="text-sm text-gray-600">Are you sure you want to remove this student from the batch? They will lose access to the course immediately.</p>
                <div class="flex items-center gap-3 pt-2">
                    <button
                        wire:click="removeStudent"
                        id="btn-confirm-remove"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-colors"
                    >
                        Remove
                    </button>
                    <button
                        wire:click="cancelRemove"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition-colors"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Student Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
        <h2 class="text-base font-bold text-finpulse-navy">Add Student</h2>
        <p class="text-xs text-gray-500">Search registered users by name or email. Any role (Free Member, Paid Subscriber, etc.) can be enrolled — batch access is independent of subscription tier.</p>

        <div class="relative">
            <input
                id="student-search"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by name or email…"
                class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border-gray-300 focus:border-finpulse-navy focus:ring focus:ring-finpulse-navy/20"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        @if($searchResults->isNotEmpty())
            <ul class="divide-y divide-gray-100 border border-gray-200 rounded-lg overflow-hidden">
                @foreach($searchResults as $user)
                    <li class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}
                                @if($user->roles->isNotEmpty())
                                    &bull; <span class="text-indigo-600 font-medium">{{ $user->roles->first()->name }}</span>
                                @endif
                            </p>
                        </div>
                        <button
                            wire:click="addStudent({{ $user->id }})"
                            id="btn-add-student-{{ $user->id }}"
                            class="ml-4 flex-shrink-0 px-3.5 py-1.5 bg-finpulse-navy text-white text-xs font-bold rounded-lg hover:bg-slate-700 transition-colors"
                        >
                            Add
                        </button>
                    </li>
                @endforeach
            </ul>
        @elseif(trim($search) !== '')
            <p class="text-sm text-gray-400 text-center py-4">No matching users found (or already enrolled).</p>
        @endif
    </div>

    <!-- Enrolled Students -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-finpulse-navy">Enrolled Students</h2>
            <span class="text-xs text-gray-500 font-medium">{{ $enrollments->count() }} {{ Str::plural('student', $enrollments->count()) }}</span>
        </div>

        @if($enrollments->isEmpty())
            <div class="py-12 text-center text-gray-400">
                <svg class="mx-auto w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <p class="text-sm font-medium text-gray-500">No students enrolled yet.</p>
                <p class="text-xs text-gray-400 mt-1">Use the search above to add students.</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Enrolled At</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Added By</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @foreach($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">{{ $enrollment->user?->name }}</p>
                                <p class="text-xs text-gray-500">{{ $enrollment->user?->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-indigo-600 font-medium">
                                {{ $enrollment->user?->roles->first()?->name ?? 'Free Member' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ $enrollment->enrolled_at?->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $enrollment->addedBy?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    wire:click="confirmRemove({{ $enrollment->user_id }})"
                                    id="btn-remove-{{ $enrollment->user_id }}"
                                    class="text-xs font-semibold text-red-500 hover:text-red-700 transition-colors"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
