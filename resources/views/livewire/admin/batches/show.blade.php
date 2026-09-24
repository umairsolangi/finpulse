<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-8 w-full min-w-0 max-w-full">
    <!-- Breadcrumb & Cohort Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-4 border-b border-slate-100 pb-5">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.batches.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-900 transition-colors bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to All Cohorts
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-mono font-bold text-purple-600 bg-purple-50 px-2.5 py-0.5 rounded-md border border-purple-200">
                    COHORT #{{ $batch->id }}
                </span>
            </div>

            @php
                $val = $batch->status?->value ?? $batch->status;
            @endphp
            @if($val === 'active')
                <span class="inline-flex items-center gap-2 text-xs font-extrabold px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    ACTIVE COHORT &bull; UNLOCKED
                </span>
            @elseif($val === 'upcoming')
                <span class="inline-flex items-center gap-2 text-xs font-extrabold px-3 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    UPCOMING COHORT &bull; SCHEDULED
                </span>
            @else
                <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 border border-slate-300">
                    COMPLETED COHORT
                </span>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $batch->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400">Curriculum Track:</span>
                        <strong class="text-slate-800 font-bold">{{ $batch->course?->title ?? '—' }}</strong>
                    </div>
                    <span class="text-slate-300">&bull;</span>
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400">Lead Mentor / Instructor:</span>
                        <span class="font-semibold text-slate-700">{{ $batch->creator?->name ?? 'System' }}</span>
                    </div>
                    @if($batch->start_date)
                        <span class="text-slate-300">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-slate-400">Kickoff Date:</span>
                            <span class="font-semibold text-slate-700">{{ $batch->start_date->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Headcount Badge -->
            <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-3 border border-slate-200 self-start lg:self-center">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-[#39E554] flex items-center justify-center font-black text-sm shadow-sm">
                    {{ $enrollments->count() }}
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-900">Enrolled Students</p>
                    <p class="text-[11px] text-slate-500">Immediate Course Access</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Notification Alerts -->
    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-900 font-semibold flex items-center gap-3 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-900 font-semibold flex items-center gap-3 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-rose-100 flex items-center justify-center text-rose-700 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Removal Confirmation Modal -->
    @if($confirmRemoveUserId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 p-6 sm:p-7 max-w-md w-full space-y-5 animate-in fade-in zoom-in-95 duration-150">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900">Revoke Student Access?</h3>
                    <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                        Are you sure you want to remove this learner from <strong>{{ $batch->name }}</strong>? They will instantly lose access to all cohort lessons and curriculum materials.
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button
                        wire:click="removeStudent"
                        id="btn-confirm-remove"
                        class="flex-1 py-2.5 px-4 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition shadow-md cursor-pointer"
                    >
                        Confirm Removal
                    </button>
                    <button
                        wire:click="cancelRemove"
                        class="flex-1 py-2.5 px-4 text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer"
                    >
                        Keep in Batch
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Student Search Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-7 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Enroll Students into Cohort Roster</h2>
                <p class="text-xs text-slate-500 mt-0.5">Search any registered user by name or email. Batch enrollment automatically grants full access, irrespective of user subscription tier.</p>
            </div>
            <span class="hidden sm:inline-block text-[11px] font-mono font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">HOTKEY: SEARCH</span>
        </div>

        <div class="relative">
            <input
                id="student-search"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search candidates by name or email address…"
                class="w-full pl-11 pr-4 py-3 text-sm rounded-xl border-slate-300 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 shadow-sm transition"
            />
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        @if($searchResults->isNotEmpty())
            <div class="rounded-xl border border-slate-200 divide-y divide-slate-100 overflow-hidden shadow-sm">
                @foreach($searchResults as $user)
                    <div class="flex items-center justify-between p-3.5 bg-slate-50/50 hover:bg-emerald-50/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-900 text-[#39E554] flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $user->name }}</p>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span>{{ $user->email }}</span>
                                    <span>&bull;</span>
                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $user->roles->first()?->name ?? 'Free Member' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button
                            wire:click="addStudent({{ $user->id }})"
                            id="btn-add-student-{{ $user->id }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 transition shadow-sm cursor-pointer hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #39E554 0%, #28a04a 100%);"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            Add to Cohort
                        </button>
                    </div>
                @endforeach
            </div>
        @elseif(trim($search) !== '')
            <div class="p-6 text-center text-slate-400 bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                <p class="text-xs font-medium">No matching candidates found (or candidate is already enrolled in this batch).</p>
            </div>
        @endif
    </div>

    <!-- Active Enrolled Roster Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden w-full max-w-full">
        <div class="px-6 py-4.5 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-[#39E554]"></div>
                <h2 class="text-base font-extrabold text-slate-900">Current Cohort Roster</h2>
            </div>
            <span class="text-xs font-bold text-slate-600 bg-white px-3 py-1 rounded-full border border-slate-200">
                {{ $enrollments->count() }} Active {{ Str::plural('Student', $enrollments->count()) }}
            </span>
        </div>

        @if($enrollments->isEmpty())
            <div class="py-16 text-center text-slate-500 px-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Roster is empty</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                    Use the candidate search above to enroll users into this cohort batch.
                </p>
            </div>
        @else
            <div class="overflow-x-auto w-full max-w-full">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-slate-600 uppercase tracking-wider">Student Profile</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-slate-600 uppercase tracking-wider">Platform Role</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-slate-600 uppercase tracking-wider">Enrollment Timestamp</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-slate-600 uppercase tracking-wider">Assigned By</th>
                            <th class="px-6 py-3.5 text-right text-xs font-extrabold text-slate-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($enrollments as $enrollment)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-[#39E554] flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                            {{ strtoupper(substr($enrollment->user?->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $enrollment->user?->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $enrollment->user?->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $enrollment->user?->roles->first()?->name ?? 'Free Member' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600 font-mono">
                                    {{ $enrollment->enrolled_at?->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                    {{ $enrollment->addedBy?->name ?? 'System Admin' }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <button
                                        wire:click="confirmRemove({{ $enrollment->user_id }})"
                                        id="btn-remove-{{ $enrollment->user_id }}"
                                        class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition-colors cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Revoke Access
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
