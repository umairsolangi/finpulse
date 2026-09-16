<div class="p-6 sm:p-8 bg-white shadow sm:rounded-xl border border-gray-200/80 space-y-6 fp-animate-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-100">
        <div>
            <h3 class="text-xl font-bold text-finpulse-navy">Subscription & Billing</h3>
            <p class="text-sm text-finpulse-gray mt-1">Manage your membership plan, billing cycle, and payment history.</p>
        </div>

        @if($subscription && $subscription->isActive())
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ ucfirst($subscription->status) }} Plan
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700 border border-gray-300">
                Free Tier
            </span>
        @endif
    </div>

    @if(session('billing_success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
            {{ session('billing_success') }}
        </div>
    @endif

    <!-- Current Plan Card -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200/90 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="text-xs uppercase tracking-wider font-semibold text-gray-500">Current Membership</div>
                <div class="text-xl font-extrabold text-finpulse-navy mt-0.5">
                    @if($subscription && $subscription->isActive())
                        Paid Subscriber Tier
                    @else
                        Free Community Member
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($subscription && $subscription->isActive())
                    <button
                        wire:click="renew"
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-xs sm:text-sm rounded-lg shadow-sm transition-all"
                    >
                        Extend 30 Days (Renew)
                    </button>
                    @if($subscription->status === 'active')
                        <button
                            wire:click="$toggle('confirmingCancellation')"
                            class="px-4 py-2 bg-white border border-gray-300 hover:bg-red-50 hover:text-red-700 hover:border-red-300 text-gray-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors"
                        >
                            Cancel Plan
                        </button>
                    @endif
                @else
                    <a
                        href="{{ route('pricing') }}"
                        wire:navigate
                        class="px-5 py-2.5 bg-[#C89B3C] hover:bg-amber-400 text-finpulse-navy font-bold text-sm rounded-lg shadow-sm transition-all hover:-translate-y-0.5"
                    >
                        Upgrade to Paid Subscriber
                    </a>
                @endif
            </div>
        </div>

        @if($subscription && $subscription->isActive())
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-gray-200/80 text-xs">
                <div>
                    <span class="text-gray-500">Status</span>
                    <p class="font-bold text-finpulse-navy capitalize mt-0.5">{{ $subscription->status }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Access Started</span>
                    <p class="font-bold text-finpulse-navy mt-0.5">{{ $subscription->starts_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Access Period Ends</span>
                    <p class="font-bold text-emerald-700 mt-0.5">{{ $subscription->ends_at->format('M d, Y (h:i A)') }}</p>
                </div>
            </div>

            @if($subscription->status === 'cancelled')
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-900">
                    ℹ️ <strong>Auto-renewal cancelled:</strong> Your paid access remains active until <strong>{{ $subscription->ends_at->format('M d, Y') }}</strong>. You can reactivate or extend anytime by clicking "Extend 30 Days".
                </div>
            @endif
        @else
            <p class="text-xs text-gray-500">
                You are currently enjoying the free features of FinPulse. Upgrade to unlock all complete courses, chapter assessments, certificates, and live financial webinars.
            </p>
        @endif
    </div>

    <!-- Cancellation Confirmation Modal / Section -->
    @if($confirmingCancellation)
        <div class="p-5 bg-red-50/80 border border-red-200 rounded-xl space-y-3">
            <h4 class="font-bold text-red-900 text-sm">Are you sure you want to cancel your plan?</h4>
            <p class="text-xs text-red-800 leading-relaxed">
                Cancelling will stop future renewal charges. You will continue to have full Paid Subscriber access until your current billing period ends on <strong>{{ $subscription?->ends_at?->format('M d, Y') }}</strong>.
            </p>
            <div class="flex items-center gap-3 pt-2">
                <button
                    wire:click="cancelSubscription"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors"
                >
                    Confirm Cancellation
                </button>
                <button
                    wire:click="$set('confirmingCancellation', false)"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold text-xs rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Keep Subscription
                </button>
            </div>
        </div>
    @endif

    <!-- Payment History -->
    <div class="space-y-4 pt-2">
        <h4 class="text-sm font-bold uppercase tracking-wider text-finpulse-navy">Recent Payment Transactions</h4>

        @if($payments->isNotEmpty())
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50 text-gray-600 font-semibold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Reference / Tracker</th>
                            <th class="py-3 px-4 text-left">Amount</th>
                            <th class="py-3 px-4 text-left">Gateway</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50/60">
                                <td class="py-3 px-4 text-gray-700 whitespace-nowrap">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4 font-mono text-gray-600 truncate max-w-[150px]">{{ $payment->gateway_transaction_id ?? 'N/A' }}</td>
                                <td class="py-3 px-4 font-bold text-finpulse-navy whitespace-nowrap">{{ $payment->currency }} {{ number_format($payment->amount) }}</td>
                                <td class="py-3 px-4 text-gray-500 uppercase">Safepay</td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-block px-2 py-0.5 rounded-full font-bold text-[10px] uppercase tracking-wide {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 rounded-xl border border-dashed border-gray-200 text-center bg-gray-50/50">
                <p class="text-xs text-gray-500">No payment records found yet.</p>
            </div>
        @endif
    </div>
</div>
