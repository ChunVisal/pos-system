<nav
    class="bg-white dark:bg-black border-b border-gray-300 dark:border-zinc-800 px-5 py-2 flex items-center justify-between sticky top-0 z-40 transition-colors duration-200">

    <img x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        init() {
            this.$watch('isDark', () => {
                this.isDark = document.documentElement.classList.contains('dark');
            });
            // Listen for dark mode changes
            const observer = new MutationObserver(() => {
                this.isDark = document.documentElement.classList.contains('dark');
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        }
    }"
        :src="isDark ? '{{ asset('images/logodarkmode.png') }}' : '{{ asset('images/logo.png') }}'" alt="Logo"
        class="w-[90px]">

        <div class="flex items-center gap-3">
            <div class="hidden md:block relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-400"></i>
                <input type="search" placeholder="Quick search inventory, invoices... (Press '/' to search)"
                    class="w-96 pl-9 py-1.5 border border-gray-400 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-zinc-100 rounded-full text-sm focus:ring-2 focus:ring-[#0F6E8C] outline-none transition-colors">
            </div>

        <x-dark-mode-toggle />

        <button
            class="relative p-2 text-gray-500 dark:text-zinc-400 hover:text-[#0F6E8C] dark:hover:text-[#138cb3] hover:bg-gray-100 dark:hover:bg-zinc-900 rounded-full transition-colors">
            <i class="bi bi-bell text-xl"></i>
            <span
                class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">3</span>
        </button>

        <div class="flex items-center gap-2">
            <div class="w-9 h-9 bg-[#0F6E8C] text-white rounded-full flex items-center justify-center font-semibold">
                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="hidden sm:block leading-none">
                <p class="font-semibold text-sm text-gray-800 dark:text-zinc-200">{{ auth()->user()->name ?? 'Guest' }}
                </p>
                <span class="text-xs text-[#0F6E8C] dark:text-[#138cb3] font-medium">{{ auth()->user()->role ?? 'User' }}</span>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        const sidebar = document.querySelector('aside');
        if (sidebar && sidebar.__x) {
            sidebar.__x.$data.open = !sidebar.__x.$data.open;
        }
    });
</script>
