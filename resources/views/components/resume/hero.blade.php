@props(['profile'])

<section aria-labelledby="hero-heading" class="flex flex-col gap-6">
    <p
        class="font-mono text-sm text-muted"
        x-data="{
            typed: 'whoami',
            init() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }

                const command = this.typed;
                let length = 0;
                this.typed = '';

                const timer = setInterval(() => {
                    this.typed = command.slice(0, ++length);

                    if (length >= command.length) {
                        clearInterval(timer);
                    }
                }, 110);
            },
        }"
    >
        <span class="text-accent" aria-hidden="true">$</span>
        <span x-text="typed">whoami</span><span class="cursor-blink text-accent" aria-hidden="true">▍</span>
    </p>

    <div class="flex flex-col gap-3">
        <h1 id="hero-heading" class="font-mono text-4xl font-bold tracking-tight sm:text-5xl">{{ $profile->name }}</h1>
        <p class="text-lg text-muted">{{ $profile->headline }}</p>
        @if ($profile->location)
            <p class="font-mono text-xs text-muted">📍 {{ $profile->location }}</p>
        @endif
    </div>

    <p class="max-w-2xl leading-relaxed">{{ $profile->bio }}</p>

    <ul class="flex flex-wrap gap-2 font-mono text-sm">
        @if ($profile->github_url)
            <li><x-resume.link-chip :href="$profile->github_url" external>github</x-resume.link-chip></li>
        @endif
        @if ($profile->linkedin_url)
            <li><x-resume.link-chip :href="$profile->linkedin_url" external>linkedin</x-resume.link-chip></li>
        @endif
        <li><x-resume.link-chip :href="'mailto:'.$profile->email">email</x-resume.link-chip></li>
        @if ($profile->show_phone && $profile->phone)
            <li><x-resume.link-chip :href="'tel:'.preg_replace('/[^0-9+]/', '', $profile->phone)">{{ $profile->phone }}</x-resume.link-chip></li>
        @endif
        <li><x-resume.link-chip :href="route('resume.print')" primary>resume.pdf ↓</x-resume.link-chip></li>
    </ul>
</section>
