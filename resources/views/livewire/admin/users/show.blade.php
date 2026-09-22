<div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex items-center justify-between gap-4">
        <a
            href="{{ route('admin.users.index') }}"
            wire:navigate
            class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-finpulse-navy hover:text-[#39E554] transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Back to User Directory</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-gray-500">User ID: #{{ $user->id }}</span>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @error('selectedRole')
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium">
            {{ $message }}
        </div>
    @enderror

    <!-- User Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-[#0B1A33] text-white flex items-center justify-center font-extrabold text-2xl shadow-sm">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-2xl font-extrabold text-finpulse-navy">{{ $user->name }}</h1>
                    @php
                        $roleBadgeClass = match($currentRole) {
                            'Admin' => 'bg-rose-100 text-rose-900 border-rose-300',
                            'Moderator' => 'bg-amber-100 text-amber-900 border-amber-300',
                            'Instructor' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                            'Paid Subscriber' => 'bg-blue-100 text-blue-900 border-blue-300',
                            default => 'bg-gray-100 text-gray-800 border-gray-300',
                        };
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $roleBadgeClass }}">
                        {{ $currentRole }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $user->email }} • Registered {{ $user->created_at->format('M d, Y (h:i A)') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 text-xs">
            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 text-center">
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Activity Score</span>
                <span class="text-lg font-black text-finpulse-navy">{{ number_format($user->activity_score ?? 0) }}</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 text-center">
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Badges Earned</span>
                <span class="text-lg font-black text-finpulse-navy">{{ $user->badges->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Role Management Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 sm:p-8 space-y-4">
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-base font-bold text-finpulse-navy">Assign Platform Role</h3>
            <p class="text-xs text-gray-500 mt-0.5">Promote or adjust this user's administrative privileges and content access level.</p>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-4 max-w-xl">
            <div class="flex-1">
                <label for="selectedRole" class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">
                    Select New Role
                </label>
                <select
                    id="selectedRole"
                    wire:model="selectedRole"
                    class="w-full text-xs rounded-xl border-gray-300 focus:border-[#0B1A33] focus:ring focus:ring-[#0B1A33]/20"
                >
                    @foreach($availableRoles as $roleOption)
                        <option value="{{ $roleOption }}">{{ $roleOption }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:pt-5">
                <button
                    wire:click="updateRole"
                    wire:confirm="Change {{ $user->name }}'s role from {{ $currentRole }} to {{ $selectedRole }}?"
                    wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-xl bg-finpulse-navy hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition-all"
                >
                    <span wire:loading.remove wire:target="updateRole">Save Role Change</span>
                    <span wire:loading wire:target="updateRole">Updating...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Grid 2-col: Role Audit History & Subscriptions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Role Change History -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-finpulse-navy">Role Change History</h3>

            @if($roleChangeLogs->isNotEmpty())
                <div class="divide-y divide-gray-100 text-xs">
                    @foreach($roleChangeLogs as $log)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $log->action->value === 'assigned' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($log->action->value) }}
                                    </span>
                                    <span class="font-bold text-finpulse-navy">{{ $log->role }}</span>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1">
                                    By: <strong>{{ $log->changedByUser->name ?? 'System' }}</strong>
                                </p>
                            </div>
                            <span class="text-gray-400 text-[11px] whitespace-nowrap">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 rounded-xl border border-dashed border-gray-200 text-center bg-gray-50/50">
                    <p class="text-xs text-gray-400">No role changes recorded yet.</p>
                </div>
            @endif
        </div>

        <!-- Subscription Records -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-finpulse-navy">Subscription History</h3>

            @if($user->subscriptions->isNotEmpty())
                <div class="divide-y divide-gray-100 text-xs">
                    @foreach($user->subscriptions as $sub)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ in_array($sub->status, ['active', 'cancelled']) && $sub->ends_at->isFuture() ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $sub->status }}
                                    </span>
                                    <span class="font-mono text-gray-500 text-[11px]">{{ $sub->gateway }}</span>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1">
                                    {{ $sub->starts_at->format('M d, Y') }} — {{ $sub->ends_at->format('M d, Y') }}
                                </p>
                            </div>
                            <span class="text-[11px] font-semibold text-gray-600">
                                Ref: {{ $sub->gateway_reference ?? 'N/A' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 rounded-xl border border-dashed border-gray-200 text-center bg-gray-50/50">
                    <p class="text-xs text-gray-400">No subscription history.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/90 p-6 space-y-4">
        <h3 class="text-sm font-bold uppercase tracking-wider text-finpulse-navy">Payment Transactions</h3>

        @if($user->payments->isNotEmpty())
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50 text-gray-600 font-semibold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-2.5 px-4 text-left">Date</th>
                            <th class="py-2.5 px-4 text-left">Reference</th>
                            <th class="py-2.5 px-4 text-left">Amount</th>
                            <th class="py-2.5 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($user->payments as $payment)
                            <tr class="hover:bg-gray-50/60">
                                <td class="py-2.5 px-4 text-gray-700 whitespace-nowrap">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="py-2.5 px-4 font-mono text-gray-500 text-[11px]">{{ $payment->gateway_transaction_id ?? 'N/A' }}</td>
                                <td class="py-2.5 px-4 font-bold text-finpulse-navy">{{ $payment->currency }} {{ number_format($payment->amount) }}</td>
                                <td class="py-2.5 px-4">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
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
                <p class="text-xs text-gray-400">No payment records found.</p>
            </div>
        @endif
    </div>
</div>
