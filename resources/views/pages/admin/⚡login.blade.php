<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Log in')] class extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $throttleKey = Str::transliterate(Str::lower($this->email).'|'.request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', ['seconds' => RateLimiter::availableIn($throttleKey), 'minutes' => ceil(RateLimiter::availableIn($throttleKey) / 60)]),
            ]);
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);
        session()->regenerate();

        $this->redirectIntended(route('admin.dashboard'), navigate: true);
    }
};
?>

<div class="mx-auto mt-16 max-w-sm">
    <form wire:submit="login" class="flex flex-col gap-4 rounded-lg border border-line bg-surface p-6">
        <p class="font-mono text-sm"><span class="text-accent">$</span> sudo login</p>

        <x-form.field label="email" for="email" :error="$errors->first('email')">
            <x-form.input id="email" type="email" wire:model="email" autocomplete="username" autofocus required />
        </x-form.field>

        <x-form.field label="password" for="password" :error="$errors->first('password')">
            <x-form.input id="password" type="password" wire:model="password" autocomplete="current-password" required />
        </x-form.field>

        <label class="flex items-center gap-2 font-mono text-xs text-muted">
            <input type="checkbox" wire:model="remember" class="accent-accent"> remember me
        </label>

        <x-form.button type="submit" class="justify-center">log in</x-form.button>
    </form>
</div>
