<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription Confirmed') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden text-center p-8 sm:p-12 space-y-6 fp-animate-in">
            <!-- Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center mx-auto text-3xl shadow-sm">
                🎉
            </div>

            <!-- Heading -->
            <div class="space-y-2">
                <span class="inline-block text-xs font-bold uppercase tracking-wider px-3 py-1 bg-amber-100 text-amber-900 rounded-full border border-amber-300">
                    Paid Subscriber Active
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-finpulse-navy tracking-tight">
                    Welcome to FinPulse Premium!
                </h1>
                <p class="text-sm sm:text-base text-gray-600 max-w-lg mx-auto leading-relaxed">
                    Your payment of <strong>{{ $payment->currency }} {{ number_format($payment->amount) }}</strong> has been verified. You now have full, unrestricted access to all masterclasses, research reports, and live interactive webinars.
                </p>
            </div>

            <!-- Details Card -->
            <div class="bg-gray-50/80 rounded-xl p-6 border border-gray-200/80 text-left max-w-md mx-auto space-y-3 text-sm">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Reference ID</span>
                    <span class="font-mono font-semibold text-xs text-finpulse-navy">{{ $payment->gateway_transaction_id }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Plan Duration</span>
                    <span class="font-semibold text-finpulse-navy">30 Days</span>
                </div>
                @if($subscription)
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Access Valid Until</span>
                        <span class="font-semibold text-emerald-700">{{ $subscription->ends_at->format('M d, Y h:i A') }}</span>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a
                    href="{{ route('courses.index') }}"
                    wire:navigate
                    class="w-full sm:w-auto px-6 py-3 bg-[#39E554] hover:bg-amber-400 text-finpulse-navy font-bold rounded-xl shadow-md transition-all hover:-translate-y-0.5"
                >
                    Explore Courses & Masterclasses
                </a>
                <a
                    href="{{ route('profile') }}"
                    wire:navigate
                    class="w-full sm:w-auto px-6 py-3 bg-finpulse-navy hover:bg-slate-800 text-white font-semibold rounded-xl transition-all"
                >
                    Manage Billing in Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
