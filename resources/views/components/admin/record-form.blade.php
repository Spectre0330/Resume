@props(['editing' => false])

<form wire:submit="save" class="mb-8 flex flex-col gap-4 rounded-lg border border-accent/50 bg-surface p-5">
    <p class="font-mono text-xs text-accent">{{ $editing ? '// editing' : '// new entry' }}</p>

    {{ $slot }}

    <div class="flex gap-2">
        <x-form.button type="submit">save</x-form.button>
        <x-form.button variant="secondary" wire:click="cancel">cancel</x-form.button>
    </div>
</form>
