<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-7">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
        <p class="text-sm text-slate-500 mt-1.5 font-medium">Log in to your FinPulse account to continue learning.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-slate-700 font-bold text-xs" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]" type="email" name="email" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-bold text-xs" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="text-xs font-bold text-[#168a43] hover:text-[#0b542c] transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>
            <x-text-input wire:model="form.password" id="password" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-lg border-slate-300 text-[#39E554] focus:ring-[#39E554] shadow-xs cursor-pointer">
                <span class="text-xs font-semibold text-slate-600">Remember this device</span>
            </label>
        </div>

        <div class="pt-3">
            <x-primary-button class="w-full justify-center">
                {{ __('Log In') }}
            </x-primary-button>
        </div>

        <div class="pt-5 text-center border-t border-slate-100 mt-6">
            <p class="text-xs sm:text-sm text-slate-500 font-medium">
                Don't have an account?
                <a href="{{ route('register') }}" wire:navigate class="font-bold text-[#168a43] hover:text-[#0b542c] transition-colors duration-150 ms-1 underline decoration-[#39E554]/50 decoration-2 underline-offset-2">
                    Create a free account
                </a>
            </p>
        </div>
    </form>
</div>