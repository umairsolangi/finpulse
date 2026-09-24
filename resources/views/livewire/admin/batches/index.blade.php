<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-indigo-100 text-indigo-800 border border-indigo-200">
                    Admin Portal
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-finpulse-navy mt-1">Batch Management</h1>
            <p class="text-xs text-gray-500">Create and manage cohort-restricted course batches.</p>
        </div>

        @can('batches.create')
            <button
                wire:click="toggleCreateForm"
                id="btn-toggle-create-batch"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-finpulse-navy text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ $showCreateForm ? 'Cancel' : 'New Batch' }}
            </button>
        @endcan
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Create Batch Form -->
    @can('batches.create')
        @if($showCreateForm)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-5">
                <h2 class="text-base font-bold text-finpulse-navy">Create New Batch</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Batch Name -->
                    <div class="sm:col-span-2">
                        <label for="batch-name" class="block text-xs font-semibold text-gray-700 mb-1">Batch Name</label>
                        <input
                            id="batch-name"
                            type="text"
                            wire:model="name"
                            placeholder="e.g. Technical Analysis — Batch 5"
                            class="w-full text-sm rounded-lg border-gray-300 focus:border-finpulse-navy focus:ring focus:ring-finpulse-navy/20"
                        />
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Course -->
                    <div>
                        <label for="batch-course" class="block text-xs font-semibold text-gray-700 mb-1">Course</label>
                        <select
                            id="batch-course"
                            wire:model="courseId"
                            class="w-full text-sm rounded-lg border-gray-300 focus:border-finpulse-navy focus:ring focus:ring-finpulse-navy/20"
                        >
                            <option value="">Select a course…</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->title }}
                                    @if(!$course->restricted_to_batches)
                                        (will enable batch-only access)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('courseId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-amber-600">
                            Selecting a course that isn't already batch-restricted will automatically enable batch-only access for it.
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="batch-status" class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                        <select
                            id="batch-status"
                            wire:model="status"
                            class="w-full text-sm rounded-lg border-gray-300 focus:border-finpulse-navy focus:ring focus:ring-finpulse-navy/20"
                        >
                            @foreach($statuses as $s)
                                <option value="{{ $s->value }}">{{ $s->label() }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="batch-start-date" class="block text-xs font-semibold text-gray-700 mb-1">Start Date <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input
                            id="batch-start-date"
                            type="date"
                            wire:model="startDate"
                            class="w-full text-sm rounded-lg border-gray-300 focus:border-finpulse-navy focus:ring focus:ring-finpulse-navy/20"
                        />
                        @error('startDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button
                        wire:click="createBatch"
                        id="btn-create-batch"
                        class="px-5 py-2.5 bg-[#39E554] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg transition-all duration-200"
                    >
                        Create Batch
                    </button>
                    <button
                        wire:click="toggleCreateForm"
                        class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-900 transition-colors"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        @endif
    @endcan

    <!-- Batches List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($batches->isEmpty())
            <div class="py-16 text-center text-gray-500">
                <svg class="mx-auto w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="font-semibold text-gray-600">No batches yet</p>
                @can('batches.create')
                    <p class="text-sm text-gray-400 mt-1">Create the first batch using the button above.</p>
                @endcan
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Batch</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Created By</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($batches as $batch)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-finpulse-navy">{{ $batch->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $batch->course?->title ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($batch->status?->value) {
                                        'active' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                        'upcoming' => 'bg-amber-100 text-amber-800 border-amber-300',
                                        'completed' => 'bg-gray-100 text-gray-700 border-gray-300',
                                        default => 'bg-gray-100 text-gray-700 border-gray-300',
                                    };
                                @endphp
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full border {{ $statusClass }}">
                                    {{ $batch->status?->label() ?? ucfirst($batch->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $batch->enrollments_count }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $batch->start_date ? $batch->start_date->format('d M Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $batch->creator?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a
                                    href="{{ route('admin.batches.show', $batch->id) }}"
                                    wire:navigate
                                    class="text-xs font-bold text-finpulse-navy hover:text-[#39E554] transition-colors"
                                >
                                    Manage →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
