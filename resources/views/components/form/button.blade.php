@props(['variant' => 'primary'])

<button {{ $attributes->merge(['type' => 'button'])->class([
    'inline-flex items-center gap-2 rounded px-4 py-2 font-mono text-sm transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent disabled:opacity-60',
    'bg-accent text-accent-ink hover:opacity-90' => $variant === 'primary',
    'border border-line text-ink hover:border-accent hover:text-accent' => $variant === 'secondary',
    'border border-danger/50 text-danger hover:bg-danger/10' => $variant === 'danger',
]) }}>
    {{ $slot }}
</button>
