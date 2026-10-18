<?php

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    /**
     * The maximum number of messages a single IP may send per hour.
     */
    public const MAX_ATTEMPTS_PER_HOUR = 3;

    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:10|max:5000')]
    public string $message = '';

    /**
     * Honeypot field: hidden from people, but naive bots fill it in.
     */
    public string $website = '';

    public bool $sent = false;

    public function send(): void
    {
        $rateLimitKey = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_ATTEMPTS_PER_HOUR)) {
            $minutes = (int) ceil(RateLimiter::availableIn($rateLimitKey) / 60);

            $this->addError('message', "Too many messages. Please try again in {$minutes} minutes.");

            return;
        }

        $validated = $this->validate();

        RateLimiter::hit($rateLimitKey, 3600);

        if ($this->website === '') {
            $contactMessage = ContactMessage::query()->create($validated);

            try {
                Mail::to(config('app.admin.email'))->send(new NewContactMessage($contactMessage));
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        $this->reset('name', 'email', 'message', 'website');
        $this->sent = true;
    }
};
?>

<div>
    @if ($sent)
        <div role="status" class="rounded-lg border border-accent/50 bg-surface p-5 font-mono text-sm">
            <p><span class="text-accent">✓</span> message delivered. I'll get back to you soon.</p>
            <button type="button" wire:click="$set('sent', false)" class="mt-3 text-xs text-muted underline underline-offset-4 hover:text-accent">
                send another
            </button>
        </div>
    @else
        <form wire:submit="send" class="flex flex-col gap-4 rounded-lg border border-line bg-surface p-5" novalidate>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-form.field label="name" for="contact-name" :error="$errors->first('name')">
                    <x-form.input id="contact-name" wire:model="name" autocomplete="name" required />
                </x-form.field>

                <x-form.field label="email" for="contact-email" :error="$errors->first('email')">
                    <x-form.input id="contact-email" type="email" wire:model="email" autocomplete="email" required />
                </x-form.field>
            </div>

            <x-form.field label="message" for="contact-message" :error="$errors->first('message')">
                <x-form.textarea id="contact-message" wire:model="message" rows="5" required />
            </x-form.field>

            <div class="absolute -left-[9999px]" aria-hidden="true">
                <label for="contact-website">Website</label>
                <input id="contact-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <x-form.button type="submit" wire:loading.attr="disabled" wire:target="send">
                    <span wire:loading.remove wire:target="send">./send</span>
                    <span wire:loading wire:target="send">sending…</span>
                </x-form.button>
            </div>
        </form>
    @endif
</div>
