<button
    type="button"
    x-data="{ isDark: document.documentElement.classList.contains('dark') }"
    x-on:click="
        isDark = ! isDark;
        document.documentElement.classList.toggle('dark', isDark);
        try { localStorage.setItem('theme', isDark ? 'dark' : 'light') } catch (error) {}
    "
    x-bind:aria-pressed="isDark.toString()"
    aria-label="Toggle dark mode"
    {{ $attributes->class('inline-flex items-center gap-1.5 rounded px-2 py-1 font-mono text-xs text-muted transition hover:text-accent focus-visible:outline-2 focus-visible:outline-accent') }}
>
    <span aria-hidden="true" x-text="isDark ? '☾' : '☀'">☾</span>
    <span x-text="isDark ? 'dark' : 'light'">dark</span>
</button>
