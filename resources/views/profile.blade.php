<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Activity Score & Badges Overview -->
            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-xl border border-gray-200/80 fp-animate-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-finpulse-navy">My Badges & Activity</h3>
                        <p class="text-sm text-finpulse-gray mt-1">Track your community engagement and unlocked achievements.</p>
                    </div>
                    <div class="inline-flex items-center gap-3 bg-amber-50 border border-amber-200 px-4 py-2.5 rounded-xl">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-amber-500 to-yellow-400 flex items-center justify-center text-white shadow-sm">
                            ⚡
                        </div>
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-amber-900">Activity Score</div>
                            <div class="text-2xl font-extrabold text-finpulse-navy">{{ auth()->user()->activity_score ?? 0 }} <span class="text-xs font-medium text-finpulse-gray font-sans">pts</span></div>
                        </div>
                    </div>
                </div>

                <!-- Badges Grid -->
                <div class="mt-6">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-finpulse-navy mb-4">Earned Badges ({{ auth()->user()->badges->count() }})</h4>

                    @if(auth()->user()->badges->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 fp-stagger-grid">
                            @foreach(auth()->user()->badges as $badge)
                                <div class="flex items-start gap-3 p-4 rounded-xl border border-amber-200/70 bg-gradient-to-br from-amber-50/60 to-white hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                                    <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-300/60 flex items-center justify-center text-xl shrink-0 text-amber-600">
                                        🏆
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-finpulse-navy text-sm">{{ $badge->name }}</div>
                                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">{{ $badge->description }}</p>
                                        <div class="text-[11px] text-amber-700/80 font-medium mt-2">
                                            Earned {{ \Carbon\Carbon::parse($badge->pivot->earned_at)->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 rounded-xl border border-dashed border-gray-200 text-center bg-gray-50/50">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-xl text-gray-400 mb-2">
                                🎖️
                            </div>
                            <p class="text-sm font-semibold text-gray-700">No badges earned yet</p>
                            <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Participate in community discussions on the feed or explore free learning modules to unlock your first badge!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Completion Certificates Overview -->
            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-xl border border-gray-200/80 fp-animate-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-finpulse-navy">My Certificates</h3>
                        <p class="text-sm text-finpulse-gray mt-1">Official verified credentials earned from completed courses.</p>
                    </div>
                    <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 px-3.5 py-2 rounded-xl text-emerald-900 text-xs font-bold">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ auth()->user()->certificates->count() }} {{ Str::plural('Certificate', auth()->user()->certificates->count()) }} Earned</span>
                    </div>
                </div>

                <div class="mt-6">
                    @if(auth()->user()->certificates->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 fp-stagger-grid">
                            @foreach(auth()->user()->certificates as $cert)
                                <div class="p-5 rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50/40 via-white to-amber-50/20 shadow-sm flex flex-col justify-between gap-4 hover:shadow-md transition-all">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-[11px] font-mono font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded">
                                                {{ $cert->certificate_number }}
                                            </span>
                                            <span class="text-[11px] text-gray-500">
                                                Issued {{ $cert->issued_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <h4 class="text-base font-bold text-finpulse-navy line-clamp-1">
                                            {{ $cert->course->title }}
                                        </h4>
                                        <p class="text-xs text-gray-600">
                                            Comprehensive mastery demonstrated across all course modules.
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                        <a
                                            href="{{ route('courses.show', $cert->course->slug) }}"
                                            wire:navigate
                                            class="text-xs font-semibold text-finpulse-navy hover:text-[#39E554] transition-colors"
                                        >
                                            View Syllabus
                                        </a>

                                        <a
                                            href="{{ route('certificates.download', $cert->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 transition-colors shadow-sm"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Download PDF</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 rounded-xl border border-dashed border-gray-200 text-center bg-gray-50/50">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-xl text-gray-400 mb-2">
                                📜
                            </div>
                            <p class="text-sm font-semibold text-gray-700">No certificates earned yet</p>
                            <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Complete all chapters and assessments in any structured course to unlock your official verified certificate of completion.</p>
                            <div class="mt-4">
                                <a
                                    href="{{ route('courses.index') }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-finpulse-navy text-white text-xs font-bold rounded-lg hover:bg-[#39E554] hover:bg-[#28a04a] transition-all"
                                >
                                    <span>Browse Courses</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Billing & Subscription Management -->
            <livewire:billing />

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
