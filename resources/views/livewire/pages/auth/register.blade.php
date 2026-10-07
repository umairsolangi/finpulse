<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('onboarding', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-7">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Create an Account</h2>
        <p class="text-sm text-slate-500 mt-1.5 font-medium">Start your journey to financial independence today.</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-slate-700 font-bold text-xs" />
            <x-text-input wire:model="name" id="name" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]" type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-slate-700 font-bold text-xs" />
            <x-text-input wire:model="email" id="email" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]" type="email" name="email" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-bold text-xs" />
            <x-text-input wire:model="password" id="password" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-700 font-bold text-xs" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1.5 w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554]"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-3">
            <x-primary-button class="w-full justify-center">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <div class="pt-5 text-center border-t border-slate-100 mt-6">
            <p class="text-xs sm:text-sm text-slate-500 font-medium">
                Already registered?
                <a href="{{ route('login') }}" wire:navigate class="font-bold text-[#168a43] hover:text-[#0b542c] transition-colors duration-150 ms-1 underline decoration-[#39E554]/50 decoration-2 underline-offset-2">
                    Log in instead
                </a>
            </p>
        </div>
    </form>
</div>

