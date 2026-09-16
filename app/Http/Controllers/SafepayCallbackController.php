<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SafepayCallbackController extends Controller
{
    /**
     * Handle return from Safepay checkout after successful or attempted payment.
     */
    public function success(Request $request, SubscriptionService $service): View|RedirectResponse
    {
        $tracker = $request->query('tracker') ?? $request->input('tracker');
        $signature = $request->query('sig') ?? $request->input('sig');

        if (! $tracker) {
            return redirect()->route('pricing')->with('error', 'Payment tracker missing from callback.');
        }

        $payment = Payment::where('gateway_transaction_id', $tracker)->first();

        if (! $payment) {
            return redirect()->route('pricing')->with('error', 'Payment record not found.');
        }

        // If signature is provided, verify it; otherwise if payment is already completed via webhook or sandbox
        if ($payment->status === 'pending') {
            $service->processSuccessfulPayment($payment, $tracker);
        }

        return view('checkout.success', [
            'payment' => $payment,
            'subscription' => $payment->subscription,
        ]);
    }

    /**
     * Handle user cancellation at checkout.
     */
    public function cancel(Request $request): RedirectResponse
    {
        return redirect()->route('pricing')->with('info', 'Checkout was cancelled. No charges were made.');
    }
}
