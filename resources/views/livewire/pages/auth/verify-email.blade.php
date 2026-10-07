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
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Verify Email</h2>
        <p class="text-sm text-slate-500 mt-1.5 font-medium">
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

        <div class="pt-3 text-center border-t border-slate-100">
            <button wire:click="logout" type="button" class="text-sm font-bold text-[#168a43] hover:text-[#0b542c] transition-colors duration-150 underline decoration-[#39E554]/50 decoration-2 underline-offset-2">
                {{ __('Log Out') }}
            </button>
        </div>
    </div>
</div>

