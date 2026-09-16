<?php

namespace App\Livewire;

use App\Services\SubscriptionService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Pricing extends Component
{
    public function subscribe(SubscriptionService $service)
    {
        if (! auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $user = auth()->user();

        if ($user->hasActiveSubscription()) {
            session()->flash('info', 'You already have an active Paid Subscriber membership.');

            return;
        }

        $session = $service->createCheckoutSession($user);

        return redirect()->away($session['checkout_url']);
    }

    public function render()
    {
        return view('livewire.pricing', [
            'price' => config('subscription.price', 1500),
            'currency' => config('subscription.currency', 'PKR'),
            'durationDays' => config('subscription.duration_days', 30),
            'hasActiveSubscription' => auth()->check() ? auth()->user()->hasActiveSubscription() : false,
            'activeSubscription' => auth()->check() ? auth()->user()->activeSubscription() : null,
        ]);
    }
}
