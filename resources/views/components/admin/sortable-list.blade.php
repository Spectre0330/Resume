@props(['empty' => 'Nothing here yet.'])

@unless ($slot->hasActualContent())
    <p class="rounded border border-dashed border-line p-6 text-center font-mono text-sm text-muted">{{ $empty }}</p>
@else
    <ul wire:sort="sort" class="flex flex-col gap-2">
        {{ $slot }}
    </ul>
    <p class="mt-3 font-mono text-xs text-muted">Drag ⠿ to reorder. Order is reflected on the public site.</p>
@endunless
