<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8 font-['DM_Sans',sans-serif]">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[#07113d] via-[#091449] to-[#050c2c] rounded-2xl p-8 sm:p-10 text-[#f7f8ff] border border-[#889eff]/20 shadow-[0_0_30px_rgba(78,91,255,0.2)] backdrop-blur-xl fp-animate-in">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#4e5bff]/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#903dff]/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2 text-[#f7f8ff]">
                    Welcome back, <span class="text-[#6d80ff] [text-shadow:0_0_20px_rgba(77,91,255,0.4)]">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-[#b6c0e7] text-sm sm:text-base max-w-lg">
                    Continue your financial learning journey. Here's what's happening on FinPulse today.
                </p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 fp-stagger-grid">
            <div class="bg-[#091449]/60 rounded-xl p-5 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover group cursor-default hover:border-[#6d80ff]/60 hover:shadow-[0_0_25px_rgba(78,91,255,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-[#aebaff] bg-[#4e5bff]/20 border border-[#889eff]/30 px-2.5 py-0.5 rounded-full">Active</span>
                </div>
                <p class="text-2xl font-extrabold text-[#f7f8ff] [text-shadow:0_0_15px_rgba(78,91,255,0.3)]">0</p>
                <p class="text-xs text-[#b6c0e7] mt-1">Courses In Progress</p>
            </div>

            <div class="bg-[#091449]/60 rounded-xl p-5 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover group cursor-default hover:border-[#6d80ff]/60 hover:shadow-[0_0_25px_rgba(78,91,255,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-[#aebaff] bg-[#903dff]/20 border border-[#889eff]/30 px-2.5 py-0.5 rounded-full">0</span>
                </div>
                <p class="text-2xl font-extrabold text-[#f7f8ff] [text-shadow:0_0_15px_rgba(78,91,255,0.3)]">0</p>
                <p class="text-xs text-[#b6c0e7] mt-1">Certificates Earned</p>
            </div>

            <div class="bg-[#091449]/60 rounded-xl p-5 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover group cursor-default hover:border-[#6d80ff]/60 hover:shadow-[0_0_25px_rgba(78,91,255,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-[#aebaff] bg-[#4e5bff]/20 border border-[#889eff]/30 px-2.5 py-0.5 rounded-full">Community</span>
                </div>
                <p class="text-2xl font-extrabold text-[#f7f8ff] [text-shadow:0_0_15px_rgba(78,91,255,0.3)]">0</p>
                <p class="text-xs text-[#b6c0e7] mt-1">Posts Shared</p>
            </div>

            <div class="bg-[#091449]/60 rounded-xl p-5 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover group cursor-default hover:border-[#6d80ff]/60 hover:shadow-[0_0_25px_rgba(78,91,255,0.2)] transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-extrabold text-[#f7f8ff] [text-shadow:0_0_15px_rgba(78,91,255,0.3)]">Free</p>
                <p class="text-xs text-[#b6c0e7] mt-1">Current Plan</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fp-animate-in">
            <!-- Continue Learning -->
            <a href="{{ route('learn.index') }}" wire:navigate class="group bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-300 block">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#f7f8ff] mb-1 group-hover:text-[#6d80ff] transition-colors">Continue Learning</h3>
                        <p class="text-sm text-[#b6c0e7]">Browse free financial courses and expand your investment knowledge.</p>
                    </div>
                    <svg class="w-5 h-5 text-[#6d80ff]/40 group-hover:text-[#6d80ff] group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>

            <!-- Join the Feed -->
            <a href="{{ route('feed') }}" wire:navigate class="group bg-[#091449]/60 rounded-2xl p-6 border border-[#889eff]/20 backdrop-blur-xl shadow-lg fp-card-hover hover:border-[#6d80ff]/60 hover:shadow-[0_0_30px_rgba(78,91,255,0.25)] transition-all duration-300 block">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4e5bff] to-[#903dff] flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(78,91,255,0.3)] group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#f7f8ff] mb-1 group-hover:text-[#6d80ff] transition-colors">Community Feed</h3>
                        <p class="text-sm text-[#b6c0e7]">Join discussions about stocks, mutual funds, and market insights.</p>
                    </div>
                    <svg class="w-5 h-5 text-[#6d80ff]/40 group-hover:text-[#6d80ff] group-hover:translate-x-1 transition-all shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
