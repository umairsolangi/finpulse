<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="{{ route('research.index') }}" wire:navigate
            class="inline-flex items-center gap-2 text-xs font-semibold text-gray-500 hover:text-[#0B1A33] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Research Catalog
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8 sm:p-10">
        <div class="border-b border-gray-100 pb-6 mb-8">
            <span class="px-2.5 py-1 text-xs font-bold uppercase tracking-wider rounded bg-[#0B1A33] text-[#C89B3C]">Research Desk</span>
            <h1 class="text-2xl sm:text-3xl font-bold font-serif text-[#0B1A33] mt-2">Publish Institutional Research</h1>
            <p class="text-sm text-gray-500 mt-1">Submit institutional market briefs, macro reports, and financial breakdowns.</p>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-[#0B1A33] mb-1">Report Title</label>
                <input type="text" id="title" wire:model="title" placeholder="e.g. Q3 Global Liquidity & Sovereign Debt Yield Analysis"
                    class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tier" class="block text-sm font-semibold text-[#0B1A33] mb-1">Access Tier</label>
                    <select id="tier" wire:model="tier"
                        class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all">
                        <option value="free">Free (Public)</option>
                        <option value="registered">Registered (Requires Login)</option>
                        <option value="paid">Paid (Subscribers Only)</option>
                    </select>
                    @error('tier') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="durationMinutes" class="block text-sm font-semibold text-[#0B1A33] mb-1">Estimated Read Time (Minutes)</label>
                    <input type="number" id="durationMinutes" wire:model="durationMinutes" min="1" max="120"
                        class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all">
                    @error('durationMinutes') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="publishedAt" class="block text-sm font-semibold text-[#0B1A33] mb-1">Publication Date & Time</label>
                <input type="datetime-local" id="publishedAt" wire:model="publishedAt"
                    class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all">
                <p class="text-xs text-gray-500 mt-1">Leave as now to publish immediately and notify active learners, or set a future date to schedule.</p>
                @error('publishedAt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-semibold text-[#0B1A33] mb-1">Report Content</label>
                <textarea id="body" wire:model="body" rows="12" placeholder="Write or paste your institutional analysis here..."
                    class="w-full px-4 py-3 text-sm bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0B1A33] focus:border-transparent transition-all font-mono"></textarea>
                <p class="text-xs text-gray-500 mt-1">The first paragraph will automatically serve as the executive summary and notification excerpt.</p>
                @error('body') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('research.index') }}" wire:navigate
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#0B1A33] text-white font-semibold text-sm hover:bg-[#13274c] shadow-sm transition-all flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">Publish Summary</span>
                    <span wire:loading wire:target="save">Publishing...</span>
                </button>
            </div>
        </form>
    </div>
</div>
