@props(['item' => null])

@if($item)
    @if(($item->type?->value ?? $item->type) === 'video')
        <!-- Video Player Placeholder Container -->
        <div class="space-y-6">
            <div class="relative w-full aspect-video bg-gray-900 rounded-xl overflow-hidden shadow-md flex items-center justify-center group border border-gray-800 fp-img-reveal">
                <div class="text-center p-6 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-[#39E554] text-finpulse-navy flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-200">Video Player Placeholder</p>
                    <p class="text-xs text-gray-400">Stream player integration ready for upcoming releases</p>
                </div>
            </div>

            @if($item->body)
                <div class="prose max-w-none text-gray-800 leading-relaxed space-y-4 text-sm sm:text-base">
                    {!! nl2br(e($item->body)) !!}
                </div>
            @endif
        </div>
    @else
        <!-- Article Content Layout -->
        <div class="prose max-w-none text-gray-800 leading-relaxed space-y-4 text-sm sm:text-base">
            {!! nl2br(e($item->body)) !!}
        </div>
    @endif
@else
    <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-200 text-gray-500">
        <p class="text-sm">Lesson notes and study material for this chapter will be available shortly.</p>
    </div>
@endif
