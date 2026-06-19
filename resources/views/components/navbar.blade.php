<nav class="bg-white border-b border-gray-300 px-5 py-2 flex items-center justify-between sticky top-0 z-40">
   
     <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[90px]">
    

    <div class="flex items-center gap-3">
        <!-- Search -->
        <div class="hidden md:block relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="search" placeholder="Search..." class="pl-9 pr-10 py-1.5 border border-gray-400 rounded-full text-sm focus:ring-2 focus:ring-[#0F6E8C]">
        </div>

        <!-- Notifications -->
        <button class="relative p-2 text-gray-500 hover:text-[#0F6E8C] hover:bg-gray-100 rounded-full">
            <i class="bi bi-bell text-xl"></i>
            <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">3</span>
        </button>

        <!-- User -->
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 bg-[#0F6E8C] text-white rounded-full flex items-center justify-center font-semibold">
                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="hidden sm:block leading-none">
                <p class="font-semibold text-sm text-gray-800">{{ auth()->user()->name ?? 'Guest' }}</p>
                <span class="text-xs text-[#0F6E8C] font-medium">@ {{ auth()->user()->role ?? 'User' }}</span>
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