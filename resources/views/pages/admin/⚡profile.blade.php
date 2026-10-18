<?php

use App\Models\Profile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Profile')] class extends Component
{
    public string $name = '';

    public string $headline = '';

    public string $bio = '';

    public string $email = '';

    public string $location = '';

    public string $phone = '';

    public bool $showPhone = false;

    public string $githubUrl = '';

    public string $linkedinUrl = '';

    public function mount(): void
    {
        $profile = Profile::current();

        if (! $profile) {
            return;
        }

        $this->name = $profile->name;
        $this->headline = $profile->headline;
        $this->bio = $profile->bio;
        $this->email = $profile->email;
        $this->location = $profile->location ?? '';
        $this->phone = $profile->phone ?? '';
        $this->showPhone = $profile->show_phone;
        $this->githubUrl = $profile->github_url ?? '';
        $this->linkedinUrl = $profile->linkedin_url ?? '';
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'headline' => 'required|string|max:200',
            'bio' => 'required|string|max:2000',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'showPhone' => 'boolean',
            'githubUrl' => 'nullable|url:https|max:255',
            'linkedinUrl' => 'nullable|url:https|max:255',
        ]);

        $attributes = [
            'name' => $validated['name'],
            'headline' => $validated['headline'],
            'bio' => $validated['bio'],
            'email' => $validated['email'],
            'location' => $validated['location'] ?: null,
            'phone' => $validated['phone'] ?: null,
            'show_phone' => $validated['showPhone'],
            'github_url' => $validated['githubUrl'] ?: null,
            'linkedin_url' => $validated['linkedinUrl'] ?: null,
        ];

        $profile = Profile::current();

        $profile ? $profile->update($attributes) : Profile::query()->create($attributes);

        session()->flash('status', 'Profile saved.');

        $this->redirectRoute('admin.profile', navigate: true);
    }
};
?>

<div>
    <x-admin.page-header title="profile" />

    <form wire:submit="save" class="flex max-w-2xl flex-col gap-5">
        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.field label="name" for="name" :error="$errors->first('name')">
                <x-form.input id="name" wire:model="name" required />
            </x-form.field>

            <x-form.field label="email" for="email" :error="$errors->first('email')">
                <x-form.input id="email" type="email" wire:model="email" required />
            </x-form.field>
        </div>

        <x-form.field label="headline" for="headline" :error="$errors->first('headline')">
            <x-form.input id="headline" wire:model="headline" required />
        </x-form.field>

        <x-form.field label="bio" for="bio" :error="$errors->first('bio')">
            <x-form.textarea id="bio" wire:model="bio" rows="4" required />
        </x-form.field>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.field label="location" for="location" :error="$errors->first('location')" hint="Optional, e.g. Seattle, WA">
                <x-form.input id="location" wire:model="location" />
            </x-form.field>

            <x-form.field label="phone" for="phone" :error="$errors->first('phone')">
                <x-form.input id="phone" type="tel" wire:model="phone" />
                <label class="mt-1 flex items-center gap-2 font-mono text-xs text-muted">
                    <input type="checkbox" wire:model="showPhone" class="accent-accent"> show phone publicly
                </label>
            </x-form.field>

            <x-form.field label="github url" for="github-url" :error="$errors->first('githubUrl')">
                <x-form.input id="github-url" type="url" wire:model="githubUrl" />
            </x-form.field>

            <x-form.field label="linkedin url" for="linkedin-url" :error="$errors->first('linkedinUrl')">
                <x-form.input id="linkedin-url" type="url" wire:model="linkedinUrl" />
            </x-form.field>
        </div>

        <div>
            <x-form.button type="submit">save profile</x-form.button>
        </div>
    </form>
</div>
