<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8 w-full min-w-0 max-w-full">
    <!-- Financial Terminal Header -->
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 text-white shadow-xl w-full max-w-full"
         style="background: radial-gradient(130% 120% at 90% 10%, rgba(57, 229, 84, 0.15) 0%, rgba(6, 26, 20, 0.98) 60%, #061a14 100%); border: 1px solid rgba(57, 229, 84, 0.25);">
        
        <!-- Background Ambient Glow -->
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-[#39E554]/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold uppercase tracking-widest text-[#39E554] bg-[#39E554]/10 border border-[#39E554]/30 shadow-[0_0_12px_rgba(57,229,84,0.2)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#39E554] animate-pulse"></span>
                        Institutional Cohorts Engine
                    </span>
                    <span class="text-white/40 text-xs font-mono">FINPULSE ACADEMY</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                    Batch &amp; Cohort Management
                </h1>
                <p class="text-sm text-white/70 max-w-2xl leading-relaxed">
                    Deploy and monitor structured trader cohorts, assign dedicated student rosters, and manage cohort-restricted financial education masterclasses.
                </p>
            </div>

            @can('batches.create')
                <div class="shrink-0">
                    <button
                        wire:click="toggleCreateForm"
                        id="btn-toggle-create-batch"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm text-slate-950 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-[#39E554]/25"
                        style="background: linear-gradient(135deg, #39E554 0%, #28a04a 100%);"
                    >
                        @if($showCreateForm)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Close Form</span>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Launch New Cohort</span>
                        @endif
                    </button>
                </div>
            @endcan
        </div>
    </div>

    <!-- Financial Analytics KPI Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Active Cohorts -->
        <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm hover:border-[#39E554]/40 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Live Active Batches</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900">{{ $activeCount }}</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Live Now</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Currently unlocked for enrolled analysts</p>
        </div>

        <!-- Total Enrolled Students -->
        <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm hover:border-[#39E554]/40 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Enrolled Headcount</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900">{{ $totalEnrollments }}</span>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">Learners</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Active cohort roster assignments</p>
        </div>

        <!-- Upcoming Batches -->
        <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm hover:border-[#39E554]/40 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Upcoming Cohorts</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900">{{ $upcomingCount }}</span>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Scheduled</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Ready for pre-launch student enrollment</p>
        </div>

        <!-- Cohort-Restricted Masterclasses -->
        <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm hover:border-[#39E554]/40 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Gated Curricula</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900">{{ $restrictedCoursesCount }}</span>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md">Courses</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Exclusive to cohort members only</p>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200/80 p-4 text-sm text-emerald-900 font-semibold flex items-center gap-3 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Create Batch Form Section -->
    @can('batches.create')
        @if($showCreateForm)
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden transition-all">
                <div class="p-6 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#39E554]">Deployment Configuration</span>
                        <h2 class="text-lg font-bold text-white mt-0.5">Initialize New Financial Cohort</h2>
                    </div>
                    <span class="text-xs font-mono text-slate-400">STATUS: CONFIGURING</span>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Batch Name -->
                        <div class="sm:col-span-2">
                            <label for="batch-name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Cohort / Batch Title <span class="text-rose-500">*</span>
                            </label>
                            <input
                                id="batch-name"
                                type="text"
                                wire:model="name"
                                placeholder="e.g. Advanced Equity Valuation &amp; DCF — Cohort 3"
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 py-2.5 px-3.5 shadow-sm transition"
                            />
                            @error('name') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Course Selection -->
                        <div>
                            <label for="batch-course" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Target Course Curriculum <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="batch-course"
                                wire:model="courseId"
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 py-2.5 px-3.5 shadow-sm transition"
                            >
                                <option value="">Choose a curriculum track…</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }}
                                        @if(!$course->restricted_to_batches)
                                            (Auto-enables Batch Restriction)
                                        @else
                                            (Cohort Restricted)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('courseId') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            <div class="mt-2 flex items-start gap-1.5 text-[11px] text-amber-700 bg-amber-50/80 rounded-lg p-2 border border-amber-200/60">
                                <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Selecting an open course will automatically mark it as <strong>Cohort-Gated</strong>. Standard subscription access will be bypassed in favor of batch enrollments.</span>
                            </div>
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <label for="batch-status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Initial Operational Status <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="batch-status"
                                wire:model="status"
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 py-2.5 px-3.5 shadow-sm transition"
                            >
                                @foreach($statuses as $s)
                                    <option value="{{ $s->value }}">{{ $s->label() }}</option>
                                @endforeach
                            </select>
                            @error('status') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            <p class="mt-2 text-[11px] text-slate-500">
                                <em>Active:</em> Unlocks course for enrolled students immediately. <em>Upcoming:</em> Enrolls students ahead of kickoff date.
                            </p>
                        </div>

                        <!-- Start Date -->
                        <div class="sm:col-span-2">
                            <label for="batch-start-date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Official Kickoff Date <span class="text-slate-400 font-normal lowercase">(optional)</span>
                            </label>
                            <input
                                id="batch-start-date"
                                type="date"
                                wire:model="startDate"
                                class="w-full sm:w-1/2 text-sm rounded-xl border-slate-300 focus:border-[#39E554] focus:ring focus:ring-[#39E554]/20 py-2.5 px-3.5 shadow-sm transition"
                            />
                            @error('startDate') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <button
                            wire:click="createBatch"
                            id="btn-create-batch"
                            class="px-6 py-2.5 text-slate-950 font-bold text-sm rounded-xl transition shadow-md hover:shadow-lg cursor-pointer"
                            style="background: linear-gradient(135deg, #39E554 0%, #28a04a 100%);"
                        >
                            Confirm &amp; Create Batch
                        </button>
                        <button
                            wire:click="toggleCreateForm"
                            class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors cursor-pointer"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    <!-- Batches Directory Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden w-full max-w-full">
        <div class="px-6 py-4.5 bg-slate-50/70 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                <h2 class="text-base font-extrabold text-slate-900 tracking-tight">Active &amp; Scheduled Cohorts Directory</h2>
            </div>
            <span class="text-xs font-semibold text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                Total: {{ $batches->count() }} {{ Str::plural('Batch', $batches->count()) }}
            </span>
        </div>

        @if($batches->isEmpty())
            <div class="py-16 text-center text-slate-500 px-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-base">No cohorts initialized yet</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                    Cohort-based courses allow high-touch financial mentorship for hand-picked students.
                </p>
                @can('batches.create')
                    <button
                        wire:click="toggleCreateForm"
                        class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition"
                    >
                        Create Your First Batch →
                    </button>
                @endcan
            </div>
        @else
            <!-- Desktop / Tablet Table View (zero horizontal scrollbar) -->
            <div class="hidden sm:block w-full">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-slate-50/70 border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 text-xs font-extrabold text-slate-600 uppercase tracking-wider">Cohort &amp; Curriculum</th>
                            <th class="py-3 px-3 text-xs font-extrabold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-3 text-xs font-extrabold text-slate-600 uppercase tracking-wider">Roster</th>
                            <th class="py-3 px-3 text-xs font-extrabold text-slate-600 uppercase tracking-wider hidden lg:table-cell">Kickoff</th>
                            <th class="py-3 px-3 text-xs font-extrabold text-slate-600 uppercase tracking-wider hidden md:table-cell">Instructor</th>
                            <th class="py-3 px-4 text-right text-xs font-extrabold text-slate-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($batches as $batch)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-[#39E554] flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                                            #{{ $batch->id }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors truncate">
                                                {{ $batch->name }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500">
                                                <span class="truncate font-medium text-slate-700">{{ $batch->course?->title ?? '—' }}</span>
                                                <span class="text-slate-300">&bull;</span>
                                                <span class="text-[10px] uppercase font-bold text-purple-700 bg-purple-50 px-1.5 py-0.2 rounded border border-purple-200 shrink-0">Cohort Gated</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    @php
                                        $val = $batch->status?->value ?? $batch->status;
                                    @endphp
                                    @if($val === 'active')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Live Active
                                        </span>
                                    @elseif($val === 'upcoming')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Upcoming
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-300">
                                            Completed
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold">
                                        <span class="text-indigo-600">{{ $batch->enrollments_count }}</span>
                                        <span class="text-[11px] font-normal text-slate-500">enrolled</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap text-xs text-slate-600 font-medium hidden lg:table-cell">
                                    {{ $batch->start_date ? $batch->start_date->format('d M Y') : 'Immediate' }}
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap text-xs text-slate-500 hidden md:table-cell">
                                    {{ $batch->creator?->name ?? 'System' }}
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a
                                        href="{{ route('admin.batches.show', $batch->id) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg bg-slate-900 text-white hover:bg-[#39E554] hover:text-slate-950 transition-all duration-200 shadow-sm"
                                    >
                                        Manage
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View (<640px) Cards with Zero Horizontal Scrolling -->
            <div class="block sm:hidden divide-y divide-slate-100 bg-white">
                @foreach($batches as $batch)
                    <div class="p-4 space-y-3 hover:bg-slate-50/60 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-lg bg-slate-900 text-[#39E554] flex items-center justify-center font-black text-xs shrink-0">
                                    #{{ $batch->id }}
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm truncate">{{ $batch->name }}</h3>
                            </div>
                            @php
                                $val = $batch->status?->value ?? $batch->status;
                            @endphp
                            @if($val === 'active')
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Active
                                </span>
                            @elseif($val === 'upcoming')
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300 shrink-0">
                                    Upcoming
                                </span>
                            @else
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-300 shrink-0">
                                    Completed
                                </span>
                            @endif
                        </div>

                        <div class="bg-slate-50 rounded-xl p-2.5 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Course:</span>
                                <span class="font-bold text-slate-800 truncate max-w-[200px]">{{ $batch->course?->title ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Enrolled Students:</span>
                                <span class="font-bold text-indigo-700">{{ $batch->enrollments_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Kickoff:</span>
                                <span class="font-medium text-slate-700">{{ $batch->start_date ? $batch->start_date->format('d M Y') : 'Immediate' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-xs text-slate-400">By {{ $batch->creator?->name ?? 'System' }}</span>
                            <a
                                href="{{ route('admin.batches.show', $batch->id) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg bg-slate-900 text-white hover:bg-[#39E554] hover:text-slate-950 transition-all shadow-sm"
                            >
                                Manage Roster
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
