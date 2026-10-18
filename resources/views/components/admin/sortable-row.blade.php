@props(['id', 'title', 'subtitle' => null])

<li wire:key="row-{{ $id }}" wire:sort:item="{{ $id }}" class="flex items-center gap-3 rounded border border-line bg-surface px-3 py-2.5">
    <button type="button" wire:sort:handle class="cursor-grab font-mono text-muted hover:text-accent" aria-label="Drag to reorder {{ $title }}">⠿</button>
    <div class="min-w-0 grow">
        <p class="truncate font-medium">{{ $title }}</p>
        @if ($subtitle)
            <p class="truncate font-mono text-xs text-muted">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="flex shrink-0 gap-2">
        <x-form.button variant="secondary" wire:click="edit({{ $id }})" class="px-2.5! py-1! text-xs!">edit</x-form.button>
        <x-form.button variant="danger" wire:click="delete({{ $id }})" wire:confirm="Delete {{ $title }}?" class="px-2.5! py-1! text-xs!">delete</x-form.button>
    </div>
</li>
