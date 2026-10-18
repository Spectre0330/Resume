{{-- Applies the saved (or system) theme before first paint to avoid a flash of the wrong palette. --}}
<script>
    (function () {
        var theme = null;

        try {
            theme = localStorage.getItem('theme');
        } catch (error) {}

        var isDark = theme ? theme === 'dark' : ! window.matchMedia('(prefers-color-scheme: light)').matches;

        document.documentElement.classList.toggle('dark', isDark);
    })();
</script>
