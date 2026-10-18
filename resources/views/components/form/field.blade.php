@props(['label', 'for', 'error' => null, 'hint' => null])

<div {{ $attributes->class('flex flex-col gap-1.5') }}>
    <label for="{{ $for }}" class="font-mono text-xs text-muted">{{ $label }}</label>
    {{ $slot }}
    @if ($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
    @if ($error)
        <p id="{{ $for }}-error" class="font-mono text-xs text-danger">{{ $error }}</p>
    @endif
</div>
