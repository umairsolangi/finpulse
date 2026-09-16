<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrokerageReferralController extends Controller
{
    /**
     * Track user referral click and redirect to the partner brokerage account opening page.
     */
    public function redirect(Request $request): RedirectResponse
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->update([
                'brokerage_referral_clicked_at' => now(),
            ]);

            Log::info("Brokerage referral link clicked by user #{$user->id} ({$user->email})");
        }

        $targetUrl = config('subscription.brokerage_url', 'https://www.ktrade.pk/open-account');

        return redirect()->away($targetUrl);
    }
}
