@props(['title'])

<section class="mt-4">
    <h2 class="mb-1.5 border-b border-neutral-300 pb-0.5 text-[10pt] font-bold tracking-wider uppercase">{{ $title }}</h2>
    <div class="flex flex-col gap-2">
        {{ $slot }}
    </div>
</section>
