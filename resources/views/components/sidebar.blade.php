<!-- Sidebar -->
<aside x-data="{ open: true }" 
       :class="open ? 'w-[200px]' : 'w-14'" 
       class="sticky top-[61px] h-[calc(100vh-61px)] flex flex-col transition-all duration-300 overflow-hidden shadow-sm z-40">

    <!-- Drag Handle -->
    <div class="absolute right-0 top-0 bottom-0 w-[1px] cursor-ew-resize hover:bg-blue-400 bg-gray-200 transition-all z-50"
         @mousedown.stop="
             let startX = $event.clientX;
             const onMove = (e) => {
                 let diff = startX - e.clientX;
                 if (diff > 30) open = false;
                 else if (diff < -30) open = true;
             };
             const onUp = () => {
                 document.removeEventListener('mousemove', onMove);
                 document.removeEventListener('mouseup', onUp);
             };
             document.addEventListener('mousemove', onMove);
             document.addEventListener('mouseup', onUp);
         ">
    </div>

<!-- Close Button (appears when open) -->
<div x-show="open" class="absolute top-1/3 -translate-y-1/2 right-0 z-50 flex items-center justify-center">
    <button @click="open = false" class="w-6 h-12 bg-gray-200/30 border border-gray-300 rounded-l-lg shadow-sm flex items-center justify-center hover:bg-gray-200/30 transition">
        <span class="text-lg text-gray-600">‹</span>
    </button>
</div>

    <!-- Menu (no logo) -->
    <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">

        <!-- Open Button (appears when closed) -->
        <div x-show="!open" class="flex items-center px-3 justify-center">
            <button @click="open = true" class=" flex items-center justify-center hover:bg-gray-200/30 transition">
                <x-heroicon-o-chevron-right class="w-7 bg-gray-200/50 rounded-sm p-1 text-gray-600" />
            </button>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-squares-2x2 class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Dashboard</span>
</a>
        
       <a href="{{ route('admin.products') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.products') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-cube class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Products</span>
</a>

<a href="{{ route('admin.inventory') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.inventory') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-archive-box class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Inventory</span>
</a>

<a href="{{ route('admin.users') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.users') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-users class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Users</span>
</a>

<a href="{{ route('admin.reports') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.reports') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-chart-bar class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Reports</span>
</a>

<a href="{{ route('admin.settings') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.settings') ? 'bg-blue-50 text-p' : 'text-gray-700 hover:bg-gray-200/30' }}"
   :class="open ? '' : 'justify-center'">
    <x-heroicon-o-cog-6-tooth class="w-5 h-5 shrink-0" />
    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Settings</span>
</a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-200/30 text-red-700 hover:text-red-900 w-full transition-all"
                    :class="open ? '' : 'justify-center'">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 shrink-0" />
                <span x-show="open" class="text-sm font-medium whitespace-nowrap">Logout</span>
            </button>
        </form>
    </nav>
</aside>