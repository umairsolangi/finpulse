<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Subscription Plans
    |--------------------------------------------------------------------------
    |
    | FinPulse offers two tiers:
    | - Free Member: Rs. 0/forever — access to free-tier content only.
    | - Paid Subscriber: Rs. 1,500/month — full access to all content tiers.
    |
    */
    'price' => (int) env('SUBSCRIPTION_PRICE', 1500),
    'currency' => env('SUBSCRIPTION_CURRENCY', 'PKR'),
    'duration_days' => (int) env('SUBSCRIPTION_DURATION_DAYS', 30),
    'renewal_reminder_days' => 3,

    /*
    |--------------------------------------------------------------------------
    | Safepay Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Safepay was chosen as the primary payment gateway because:
    | 1. Official PHP SDK (getsafepay/sfpy-php) with Express Checkout support.
    | 2. Native PKR currency support — no FX conversion needed.
    | 3. Hosted checkout page — FinPulse never touches raw card data (PCI-safe).
    | 4. Documented webhook signature verification via X-SFPY-SIGNATURE header.
    |
    | No Laravel Cashier equivalent exists for Pakistani gateways, so this is
    | a custom direct API integration.
    |
    */
    'safepay' => [
        'api_key' => env('SAFEPAY_API_KEY', ''),
        'v1_secret' => env('SAFEPAY_V1_SECRET', ''),
        'webhook_secret' => env('SAFEPAY_WEBHOOK_SECRET', ''),
        'environment' => env('SAFEPAY_ENVIRONMENT', 'sandbox'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Brokerage Referral
    |--------------------------------------------------------------------------
    */
    'brokerage_url' => env('BROKERAGE_REFERRAL_URL', 'https://www.ktrade.pk/open-account'),
];
