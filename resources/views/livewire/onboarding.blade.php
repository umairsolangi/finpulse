<div class="min-h-[80vh] flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    <!-- Progress / Welcome Pill -->
    <div class="text-center mb-8 fp-animate-in">
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-300 shadow-sm">
            ✨ Welcome to FinPulse
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy mt-3 tracking-tight">
            What are you interested in?
        </h1>
        <p class="text-sm sm:text-base text-finpulse-gray mt-2 max-w-lg mx-auto leading-relaxed">
            Choose <span class="font-bold text-finpulse-navy">2 to 3 topics</span> so we can customize your financial
            learning path and community recommendations.
        </p>
    </div>

    <!-- Error Summary -->
    @error('selectedInterests')
        <div
            class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-semibold flex items-center gap-2 fp-animate-in">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    @enderror

    <!-- Categories Cards Grid -->
    <form wire:submit="submit" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 fp-stagger-grid">
            @foreach($categories as $category)
                @php
                    $isSelected = in_array($category['value'], $selectedInterests);
                @endphp
                <div wire:click="toggleInterest('{{ $category['value'] }}')"
                    class="relative cursor-pointer rounded-2xl p-5 border-2 transition-all duration-200 select-none group hover:-translate-y-1 hover:shadow-lg {{ $isSelected ? 'border-[#0B1A33] bg-white ring-2 ring-[#0B1A33]/15 shadow-md' : 'border-gray-200 bg-white hover:border-gray-300 shadow-sm' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div
                            class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl bg-gray-50 border border-gray-100 group-hover:scale-110 transition-transform duration-200">
                            {{ $category['icon'] }}
                        </div>

                        <!-- Checkmark Indicator -->
                        <div
                            class="w-6 h-6 rounded-full border flex items-center justify-center transition-all {{ $isSelected ? 'bg-[#0B1A33] border-[#0B1A33] text-white shadow-sm' : 'border-gray-300 bg-white text-transparent group-hover:border-gray-400' }}">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-bold text-gray-900 text-base group-hover:text-finpulse-navy">
                            {{ $category['label'] }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            {{ $category['description'] }}
                        </p>
                    </div>

                    @if($isSelected)
                        <div class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold text-[#C89B3C]">
                            <span>Selected</span> ✓
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Counter & Continue Button -->
        <div
            class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-200 fp-animate-in">
            <div class="text-xs sm:text-sm text-finpulse-gray font-medium text-center sm:text-left">
                <span>Selected:</span>
                <span
                    class="font-bold {{ count($selectedInterests) >= 2 && count($selectedInterests) <= 3 ? 'text-emerald-600' : 'text-finpulse-navy' }}">
                    {{ count($selectedInterests) }} of 3 max
                </span>
                <span class="text-gray-400 text-xs ml-1">(min. 2 required)</span>
            </div>

            <button type="submit"
                class="w-full sm:w-auto px-8 py-3 bg-[#0B1A33] hover:bg-[#C89B3C] text-white hover:text-[#0B1A33] font-bold text-sm rounded-xl transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 disabled:opacity-50 disabled:pointer-events-none flex items-center justify-center gap-2"
                {{ count($selectedInterests) < 2 ? 'disabled' : '' }}>
                <span>Continue to Learning</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
</div>