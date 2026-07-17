<nav
    class="bg-white dark:bg-black border-b border-gray-300 dark:border-zinc-800 px-5 py-2 pb-[10px] flex items-center justify-between sticky top-0 z-40 transition-colors duration-200">

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

        {{-- Bell Icon with Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative p-2 text-gray-700 dark:text-zinc-300 hover:text-[#0F6E8C] dark:hover:text-[#138cb3] hover:bg-gray-100 dark:hover:bg-zinc-900 rounded-full transition-colors">
                <i class="fa-solid fa-bell text-xl"></i>
                @php $pendingCount = \App\Models\StockRequest::where('status', 'pending')->count(); @endphp
                @if ($pendingCount > 0)
                    <span
                        class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.outside="open = false" x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                class="absolute right-0 mt-2 w-80 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-md shadow-xl dark:shadow-zinc-950/50 z-50 overflow-hidden">

                {{-- Premium Minimal Header Segment Layout --}}
                <div
                    class="px-4 py-3 bg-gray-50/50 dark:bg-zinc-900/40 border-b border-gray-100 dark:border-zinc-800/60 flex items-center justify-between">
                    <h3 class="text-xs font-bold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">
                        Notifications</h3>
                    <a href="{{ route('admin.notifications') }}"
                        class="text-[11px] font-bold text-[#0F6E8C] dark:text-[#1389af] hover:underline uppercase tracking-wider">
                        View All
                    </a>
                </div>

                {{-- Notification List Feed Container Block --}}
                <div class="max-h-[320px] overflow-y-auto divide-y divide-gray-100 dark:divide-zinc-800/40">
                    @php
                        $notifications = \App\Models\StockRequest::with(['cashier', 'product'])
                            ->where('status', 'pending')
                            ->latest()
                            ->limit(6)
                            ->get();
                    @endphp

                    @forelse($notifications as $notif)
                        <a href="{{ route('admin.notifications') }}"
                            class="flex items-start gap-3 px-4 py-3.5 hover:bg-gray-50/60 dark:hover:bg-zinc-800/30 transition-colors">

                            {{-- Product Thumbnail Image Container With Dynamic Indicator Badge --}}
                            <div class="relative flex-shrink-0">
                                <div
                                    class="w-11 h-11 rounded-md bg-gray-100 dark:bg-zinc-850 border border-gray-200/60 dark:border-zinc-800 overflow-hidden flex items-center justify-center">
                                    @if (!empty($notif->product->image))
                                        <img src="{{ $notif->product->image }}" alt="{{ $notif->product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                            alt="Placeholder" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                {{-- Pending Status Badge Dynamic Overlay Ring Element --}}
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center border-2 border-white dark:border-zinc-900 bg-amber-500">
                                    <x-heroicon-s-clock class="w-2.5 h-2.5 text-white" />
                                </div>
                            </div>

                            {{-- Text Content Meta Data Block Layout --}}
                            <div class="flex-1 min-w-0 space-y-0.5">
                                <p class="text-xs text-gray-800 dark:text-zinc-200 leading-snug break-words">
                                    <span
                                        class="font-bold text-gray-950 dark:text-zinc-50">{{ $notif->cashier->name }}</span>
                                    <span class="text-gray-500 dark:text-zinc-400">requested</span>
                                    <span
                                        class="font-bold text-[#0F6E8C] dark:text-[#1389af]">{{ $notif->quantity_requested }}x</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-zinc-100">{{ $notif->product->name ?? $notif->product_name ?? 'Unknown Product' }}</span>
                                </p>

                                <div class="flex items-center gap-1.5 pt-0.5">
                                    <span
                                        class="text-[10px] font-bold tracking-normal bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-950/40 px-1 py-0.5 rounded">
                                        Pending
                                    </span>
                                    <span class="text-[10px] text-gray-400 dark:text-zinc-500 font-medium">
                                        {{ $notif->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- Empty Placeholder Visual Representation Block --}}
                        <div class="px-4 py-12 text-center text-xs font-medium text-gray-400 dark:text-zinc-500">
                            <x-heroicon-o-check-circle class="w-6 h-6 mx-auto mb-2 opacity-60" />
                            No pending requests
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold overflow-hidden"
                style="background-color: {{ auth()->user()->role === 'admin' ? '#8B5CF6' : '#0F6E8C' }};">
                @if (auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                @else
                    <span class="text-white">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                @endif
            </div>
            <div class="hidden sm:block leading-none">
                <p class="font-semibold text-sm text-gray-800 dark:text-zinc-200">{{ auth()->user()->name ?? 'Guest' }}
                </p>
                <span
                    class="text-xs text-[#0F6E8C] dark:text-[#138cb3] font-medium">{{ auth()->user()->role ?? 'User' }}</span>
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
