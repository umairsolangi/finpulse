<?php

namespace App\Livewire;

use App\Services\SubscriptionService;
use Livewire\Component;

class Billing extends Component
{
    public bool $confirmingCancellation = false;

    public function cancelSubscription(SubscriptionService $service)
    {
        $user = auth()->user();
        $subscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();

        if ($subscription) {
            $service->cancelSubscription($subscription);
            session()->flash('billing_success', 'Your subscription auto-renewal has been cancelled. Your paid access remains active until '.$subscription->ends_at->format('M d, Y').'.');
        }

        $this->confirmingCancellation = false;
    }

    public function renew(SubscriptionService $service)
    {
        $user = auth()->user();
        $session = $service->createCheckoutSession($user);

        return redirect()->away($session['checkout_url']);
    }

    public function render()
    {
        $user = auth()->user();

        $activeSubscription = $user->subscriptions()
            ->whereIn('status', ['active', 'cancelled'])
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();

        $payments = $user->payments()
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.billing', [
            'subscription' => $activeSubscription,
            'payments' => $payments,
            'hasPaidAccess' => $user->hasPaidAccess(),
        ]);
    }
}
