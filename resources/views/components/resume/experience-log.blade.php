@props(['experiences'])

<ol class="ml-1.5 border-l border-line">
    @foreach ($experiences as $experience)
        <li wire:key="experience-{{ $experience->id }}" class="relative pb-10 pl-6 last:pb-0">
            <span
                aria-hidden="true"
                @class([
                    'absolute top-1.5 -left-[5.5px] size-2.5 rounded-full border-2',
                    'border-accent bg-accent' => $experience->ended_on === null,
                    'border-muted bg-canvas' => $experience->ended_on !== null,
                ])
            ></span>

            <p class="font-mono text-xs text-date">{{ $experience->period() }}</p>
            <h3 class="mt-1 font-semibold">
                {{ $experience->role }}
                <span class="font-normal text-muted">@ {{ $experience->company }}</span>
            </h3>
            @if ($experience->location)
                <p class="text-xs text-muted">{{ $experience->location }}</p>
            @endif

            <ul class="mt-3 flex flex-col gap-1.5 text-sm leading-relaxed">
                @foreach ($experience->bullets as $bullet)
                    <li class="flex gap-2">
                        <span class="font-mono text-accent" aria-hidden="true">-</span>
                        <span>{{ $bullet }}</span>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ol>
