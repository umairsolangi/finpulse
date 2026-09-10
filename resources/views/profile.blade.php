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
