<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Refund & Cancellation Policy') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8 fp-animate-in">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 space-y-8">
            <div class="border-b border-gray-100 pb-6 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                    Consumer Rights & Billing
                </span>
                <h1 class="text-3xl font-extrabold text-finpulse-navy">Refund & Cancellation Policy</h1>
                <p class="text-xs text-gray-400">Last updated: September 15, 2026 • Requires Legal Review Prior to Production Launch</p>
            </div>

            <div class="space-y-6 text-sm text-gray-700 leading-relaxed">
                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">1. Subscription Cancellation</h2>
                    <p>You may cancel your Paid Subscriber membership at any time directly through your <a href="{{ route('profile') }}" class="font-bold underline text-[#0B1A33]">Profile & Billing settings</a>. When you cancel, future recurring billing is immediately stopped.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">2. Retention of Paid Access Until Expiry</h2>
                    <p>Upon cancellation, you will continue to enjoy full, unrestricted Paid Subscriber access to courses, research summaries, and live sessions until the end of your current 30-day paid billing cycle. No further automatic renewals will occur.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">3. Refund Requests & Digital Goods</h2>
                    <p>Because digital education materials, proprietary financial models, and course completion certificates are delivered immediately upon account activation, monthly subscription fees are generally non-refundable once content has been accessed.</p>
                    <p>Exceptions are evaluated on a case-by-case basis (e.g. duplicate charges caused by network errors or technical failure preventing platform access). To request a review, contact <code class="text-xs bg-gray-100 px-1 py-0.5 rounded">support@finpulse.pk</code> within 48 hours of transaction.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">4. Chargebacks & Dispute Resolution</h2>
                    <p>We encourage members to contact our support team before initiating banking disputes. Unjustified chargebacks may result in permanent account suspension across the FinPulse network.</p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
