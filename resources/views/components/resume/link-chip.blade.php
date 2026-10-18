@props(['href', 'external' => false, 'primary' => false])

<a
    href="{{ $href }}"
    @if ($external) target="_blank" rel="noopener noreferrer" @endif
    {{ $attributes->class([
        'inline-flex items-center gap-1 rounded border px-3 py-1.5 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent',
        'border-accent bg-accent text-accent-ink hover:opacity-90' => $primary,
        'border-line text-ink hover:border-accent hover:text-accent' => ! $primary,
    ]) }}
>
    {{ $slot }}@if ($external)<span aria-hidden="true">↗</span><span class="sr-only"> (opens in a new tab)</span>@endif
</a>
