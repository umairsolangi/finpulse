<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Terms of Service') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8 fp-animate-in">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 space-y-8">
            <!-- Header -->
            <div class="border-b border-gray-100 pb-6 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                    Legal & Compliance
                </span>
                <h1 class="text-3xl font-extrabold text-finpulse-navy">Terms of Service</h1>
                <p class="text-xs text-gray-400">Last updated: September 15, 2026 • Requires Legal Review Prior to Production Launch</p>
            </div>

            <!-- Important Financial Advisory Notice -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl text-xs text-amber-900 leading-relaxed">
                <strong>Financial Disclaimer:</strong> FinPulse is an educational platform designed to provide financial literacy, market research, and interactive learning. Content published on FinPulse does not constitute personalized financial, investment, tax, or legal advice. All investments carry risk, including loss of principal.
            </div>

            <!-- Content Sections -->
            <div class="space-y-6 text-sm text-gray-700 leading-relaxed">
                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">1. Acceptance of Terms</h2>
                    <p>By accessing or using the FinPulse website, mobile applications, courses, or subscription services, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">2. User Accounts & Registration</h2>
                    <p>You must provide accurate, complete information when creating an account. You are solely responsible for maintaining the confidentiality of your credentials and for all activities under your account.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">3. Paid Subscriptions & Billing</h2>
                    <p>Paid Subscriber tiers are billed on a recurring monthly cycle (30-day basis) in Pakistani Rupees (PKR) through our authorized payment gateway partner, Safepay. By subscribing, you authorize FinPulse and Safepay to process recurring charges until cancellation.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">4. Intellectual Property & Course Materials</h2>
                    <p>All curriculum, video lessons, quizzes, research summaries, financial models, and completion certificates are the proprietary property of FinPulse or its content creators. Materials are licensed strictly for personal, non-commercial educational use.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">5. Third-Party Brokerage Links</h2>
                    <p>FinPulse may provide referral links to licensed brokerages (such as KASB / KTrade). FinPulse may receive referral compensation if you open an account. Account opening and brokerage transactions are governed exclusively by the broker's terms.</p>
                </section>

                <section class="space-y-2">
                    <h2 class="text-lg font-bold text-finpulse-navy">6. Governing Law</h2>
                    <p>These Terms are governed by and construed in accordance with the laws of the Islamic Republic of Pakistan and SECP regulations.</p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
