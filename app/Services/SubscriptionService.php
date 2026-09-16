<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Safepay\Checkout;
use Safepay\SafepayClient;
use Safepay\WebhookSignature;

class SubscriptionService
{
    protected ?SafepayClient $client = null;

    protected string $environment;

    protected string $apiKey;

    protected string $v1Secret;

    protected string $webhookSecret;

    public function __construct()
    {
        $this->environment = (string) config('subscription.safepay.environment', 'sandbox');
        $this->apiKey = (string) config('subscription.safepay.api_key', '');
        $this->v1Secret = (string) config('subscription.safepay.v1_secret', '');
        $this->webhookSecret = (string) config('subscription.safepay.webhook_secret', '');

        if (! empty($this->apiKey) && ! empty($this->v1Secret)) {
            try {
                $this->client = new SafepayClient([
                    'api_key' => $this->apiKey,
                    'v1_secret' => $this->v1Secret,
                    'environment' => $this->environment,
                ]);
            } catch (\Throwable $e) {
                Log::warning('SafepayClient initialization error: '.$e->getMessage());
            }
        }
    }

    /**
     * Create a pending payment and generate Safepay checkout redirect URL.
     *
     * @return array{payment: Payment, checkout_url: string, tracker: string}
     */
    public function createCheckoutSession(User $user): array
    {
        $amount = (float) config('subscription.price', 1500);
        $currency = (string) config('subscription.currency', 'PKR');
        $tracker = 'tr_'.Str::random(24);

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'currency' => $currency,
            'status' => 'pending',
            'gateway_transaction_id' => $tracker,
        ]);

        $successUrl = route('checkout.success', ['tracker' => $tracker]);
        $cancelUrl = route('checkout.cancel', ['tracker' => $tracker]);

        // Attempt Safepay Order creation if configured
        if ($this->client) {
            try {
                $order = $this->client->order->create([
                    'amount' => (int) ($amount * 100), // in minor units
                    'currency' => $currency,
                ]);

                if (isset($order['token'])) {
                    $tracker = $order['token'];
                    $payment->update(['gateway_transaction_id' => $tracker]);
                }

                $checkoutUrl = Checkout::constructURL([
                    'environment' => $this->environment,
                    'tracker' => $tracker,
                    'tbt' => $order['token'] ?? $tracker,
                    'redirect_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'source' => 'custom',
                ]);

                return [
                    'payment' => $payment,
                    'checkout_url' => $checkoutUrl,
                    'tracker' => $tracker,
                ];
            } catch (\Throwable $e) {
                Log::error('Safepay order creation failed, falling back to direct URL: '.$e->getMessage());
            }
        }

        // Fallback for sandbox / mock testing without live credentials
        $fallbackUrl = route('checkout.success', [
            'tracker' => $tracker,
            'sig' => hash_hmac('sha512', $tracker, $this->webhookSecret ?: 'test_secret'),
        ]);

        return [
            'payment' => $payment,
            'checkout_url' => $fallbackUrl,
            'tracker' => $tracker,
        ];
    }

    /**
     * Verify incoming webhook signature against configured webhook secret.
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        if (empty($signature) || empty($this->webhookSecret)) {
            return false;
        }

        try {
            return WebhookSignature::verifyHeader($payload, $signature, $this->webhookSecret);
        } catch (\Throwable $e) {
            Log::warning('Safepay webhook signature mismatch: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Verify tracker signature returned on checkout success redirect.
     */
    public function verifyTrackerSignature(string $tracker, string $signature): bool
    {
        if (empty($tracker) || empty($signature) || empty($this->webhookSecret)) {
            return false;
        }

        $expected = hash_hmac('sha512', $tracker, $this->webhookSecret);

        return hash_equals($expected, $signature);
    }

    /**
     * Handle incoming Safepay webhook payload and update subscription status.
     */
    public function handleWebhookPayload(array $payload, string $signature): array
    {
        $rawPayload = json_encode($payload);

        if (! $this->verifyWebhookSignature($rawPayload, $signature)) {
            return [
                'status' => 'error',
                'message' => 'Invalid webhook signature',
            ];
        }

        $tracker = $payload['data']['tracker'] ?? $payload['tracker'] ?? null;
        $orderId = $payload['data']['order_id'] ?? $payload['order_id'] ?? null;

        $payment = null;
        if ($tracker) {
            $payment = Payment::where('gateway_transaction_id', $tracker)->first();
        }
        if (! $payment && $orderId) {
            $payment = Payment::find($orderId);
        }

        if (! $payment) {
            return [
                'status' => 'error',
                'message' => 'Associated payment not found',
            ];
        }

        $subscription = $this->processSuccessfulPayment($payment, (string) ($tracker ?? $payment->gateway_transaction_id));

        return [
            'status' => 'success',
            'payment' => $payment,
            'subscription' => $subscription,
        ];
    }

    /**
     * Mark payment completed and activate/extend user's 30-day subscription.
     */
    public function processSuccessfulPayment(Payment $payment, string $gatewayReference): Subscription
    {
        $payment->update([
            'status' => 'completed',
            'gateway_transaction_id' => $gatewayReference,
        ]);

        $user = $payment->user;
        $durationDays = (int) config('subscription.duration_days', 30);

        // Check if user has an existing active/cancelled subscription
        $existing = $user->subscriptions()
            ->whereIn('status', ['active', 'cancelled'])
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();

        if ($existing) {
            // Extend existing subscription by durationDays
            $existing->update([
                'status' => 'active',
                'ends_at' => $existing->ends_at->addDays($durationDays),
                'gateway_reference' => $gatewayReference,
            ]);
            $subscription = $existing;
        } else {
            // Create a brand new active subscription
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays($durationDays),
                'gateway' => 'safepay',
                'gateway_reference' => $gatewayReference,
            ]);
        }

        $payment->update(['subscription_id' => $subscription->id]);

        return $subscription;
    }

    /**
     * Cancel an active subscription (access persists until ends_at).
     */
    public function cancelSubscription(Subscription $subscription): Subscription
    {
        $subscription->update(['status' => 'cancelled']);

        return $subscription;
    }
}
