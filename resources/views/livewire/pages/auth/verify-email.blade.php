<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-finpulse-navy">Verify Email</h2>
        <p class="text-sm text-finpulse-gray mt-1">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we sent to your inbox.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg p-3">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4 pt-2">
        <x-primary-button wire:click="sendVerification" class="w-full justify-center">
            {{ __('Resend Verification Email') }}
        </x-primary-button>

        <div class="pt-2 text-center border-t border-gray-100">
            <button wire:click="logout" type="button" class="text-sm font-semibold text-finpulse-navy hover:text-finpulse-gold transition-colors duration-150">
                {{ __('Log Out') }}
            </button>
        </div>
    </div>
</div>

