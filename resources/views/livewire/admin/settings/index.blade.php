<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
    <!-- Admin Top Bar & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md bg-red-100 text-red-800 border border-red-200">
                    Admin Portal
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-finpulse-navy mt-1">Platform Settings</h1>
            <p class="text-xs text-gray-500">Core application configurations, payment gateway parameters, and access policies.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a
                href="{{ route('admin.users.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Users List
            </a>
            <a
                href="{{ route('admin.roles.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Role Matrix
            </a>
            <a
                href="{{ route('admin.role-changes.index') }}"
                wire:navigate
                class="px-3.5 py-2 text-xs font-bold rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition-colors"
            >
                Role Audit Trail
            </a>
        </div>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Platform Environment Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-[#0B1A33] text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-finpulse-navy">Platform Environment</h2>
                    <p class="text-xs text-gray-500">Global system runtime and localization parameters</p>
                </div>
            </div>

            <div class="divide-y divide-gray-100 text-xs">
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Application Name</span>
                    <span class="font-semibold text-gray-900">{{ config('app.name', 'FinPulse') }}</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Environment</span>
                    <span class="font-mono text-[11px] px-2 py-0.5 rounded bg-gray-100 font-bold text-gray-800">{{ app()->environment() }}</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Default Currency</span>
                    <span class="font-semibold text-gray-900">PKR (₨)</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Default Member Role</span>
                    <span class="font-semibold text-gray-900">Free Member</span>
                </div>
            </div>
        </div>

        <!-- Payment Gateway Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-finpulse-navy">Payment Gateway (Safepay)</h2>
                    <p class="text-xs text-gray-500">Live subscription billing status and webhook handling</p>
                </div>
            </div>

            <div class="divide-y divide-gray-100 text-xs">
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Gateway Provider</span>
                    <span class="font-semibold text-gray-900">Safepay Pakistan</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Sandbox Mode</span>
                    <span class="font-semibold text-emerald-700">Enabled</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Subscription Plans</span>
                    <span class="font-semibold text-gray-900">Monthly (₨1,500) / Annual (₨15,000)</span>
                </div>
                <div class="py-2.5 flex justify-between">
                    <span class="text-gray-500">Webhook Endpoints</span>
                    <span class="font-mono text-[11px] text-gray-600">/billing/webhook/safepay</span>
                </div>
            </div>
        </div>
    </div>
</div>
