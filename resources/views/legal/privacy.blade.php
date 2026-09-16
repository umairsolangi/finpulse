<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Privacy Policy') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8 fp-animate-in">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 space-y-8">
            <div class="border-b border-gray-100 pb-6 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Data Protection & Privacy
                </span>
                <h1 class="text-3xl font-extrabold text-finpulse-navy">Privacy Policy</h1>
                <p class="text-xs text-gray-400">Last updated: September 15, 2026 • Requires Legal Review Prior to Production Launch</p>
            </div>

            <div class="space-y-6 text-sm text-gray-700 leading-relaxed">
                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">1. Information We Collect</h2>
                    <p>We collect information you provide directly (such as name, email address, password, learning preferences, and quiz responses) as well as automated data (such as login timestamps, course progress, and referral interactions).</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">2. Payment & Cardholder Information</h2>
                    <p>FinPulse does <strong>not</strong> collect, process, or store raw credit/debit card details, CVV codes, or bank credentials. All financial transactions are handled securely by our licensed gateway partner, Safepay, using tokenized PCI-DSS compliant processing.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">3. How We Use Your Information</h2>
                    <p>We use collected data to deliver personalized course content, track certificate issuance, send automated session reminders and renewal alerts, calculate activity scores, and enhance community interactions.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">4. Data Sharing & Third Parties</h2>
                    <p>We do not sell personal data. We only share necessary data with authorized service providers (e.g. email delivery services, payment gateways, and regulatory authorities when strictly required by law).</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">5. Contact Us</h2>
                    <p>For questions regarding your data privacy, email us at <code class="text-xs bg-gray-100 px-1 py-0.5 rounded">privacy@finpulse.pk</code>.</p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
