@props(['command'])

<h2 {{ $attributes->class('mb-6 flex flex-wrap items-baseline gap-x-3 font-mono text-sm font-medium') }}>
    <span><span class="text-accent" aria-hidden="true">$ </span><span class="text-ink">{{ $command }}</span></span>
    <span class="text-muted"><span aria-hidden="true"># </span>{{ $slot }}</span>
</h2>
