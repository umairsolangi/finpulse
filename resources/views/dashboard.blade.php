<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[#0B1A33] via-[#132a4e] to-[#1a3a5c] rounded-2xl p-8 sm:p-10 text-white fp-animate-in">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#C89B3C]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#4e5bff]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                    Welcome back, <span class="text-[#C89B3C]">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-white/60 text-sm sm:text-base max-w-lg">
                    Continue your financial learning journey. Here's what's happening on FinPulse today.
                </p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 fp-stagger-grid">
            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm fp-card-hover group cursor-default">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0B1A33] flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Active</span>
                </div>
                <p class="text-2xl font-extrabold text-[#0B1A33]">0</p>
                <p class="text-xs text-gray-500 mt-1">Courses In Progress</p>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm fp-card-hover group cursor-default">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-[#C89B3C] flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-[#0B1A33]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">0</span>
                </div>
                <p class="text-2xl font-extrabold text-[#0B1A33]">0</p>
                <p class="text-xs text-gray-500 mt-1">Certificates Earned</p>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm fp-card-hover group cursor-default">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0B1A33] flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Community</span>
                </div>
                <p class="text-2xl font-extrabold text-[#0B1A33]">0</p>
                <p class="text-xs text-gray-500 mt-1">Posts Shared</p>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm fp-card-hover group cursor-default">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0B1A33] to-[#1a3a5c] flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-[#C89B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-extrabold text-[#0B1A33]">Free</p>
                <p class="text-xs text-gray-500 mt-1">Current Plan</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fp-animate-in">
            <!-- Continue Learning -->
            <a href="{{ route('learn.index') }}" wire:navigate class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm fp-card-hover block">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#0B1A33] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-[#C89B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0B1A33] mb-1 group-hover:text-[#C89B3C] transition-colors">Continue Learning</h3>
                        <p class="text-sm text-gray-500">Browse free financial courses and expand your investment knowledge.</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C89B3C] group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>

            <!-- Join the Feed -->
            <a href="{{ route('feed') }}" wire:navigate class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm fp-card-hover block">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#C89B3C] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-[#0B1A33]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0B1A33] mb-1 group-hover:text-[#C89B3C] transition-colors">Community Feed</h3>
                        <p class="text-sm text-gray-500">Join discussions about stocks, mutual funds, and market insights.</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C89B3C] group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
