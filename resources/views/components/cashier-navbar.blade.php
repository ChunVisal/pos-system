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

        <x-dark-mode-toggle />

        {{-- Cashier Bell Icon with Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative p-2 text-gray-500 dark:text-zinc-400 hover:text-[#0F6E8C] dark:hover:text-[#138cb3] hover:bg-gray-100 dark:hover:bg-zinc-900 rounded-full transition-colors">
                <i class="fa-solid fa-bell text-xl"></i>
                @php
                    $cashierNotifCount = \App\Models\StockRequest::where('cashier_id', auth()->id())
                        ->where('created_at', '>=', now()->subDays(30))
                        ->whereIn('status', ['pending', 'approved', 'rejected', 'on_hold'])
                        ->count();
                @endphp
                @if ($cashierNotifCount > 0)
                    <span
                        class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">
                        {{ $cashierNotifCount }}
                    </span>
                @endif
            </button>


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
                    <h3 class="text-xs font-semibold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">
                        Notifications</h3>
                    <a href="{{ route('cashier.notifications') }}"
                        class="text-[12px] font-medium text-[#0F6E8C] dark:text-[#1389af] underline tracking-normal">
                        View All
                    </a>
                </div>

                {{-- Notification List Feed Container Block --}}
                <div
                    class="max-h-[320px] tab-container overflow-y-auto divide-y divide-gray-100 dark:divide-zinc-800/40">
                    @php
                        $pendingCashierNotifs = \App\Models\StockRequest::with(['product', 'approver'])
                            ->where('cashier_id', auth()->id())
                            ->where('created_at', '>=', now()->subDays(30))
                            ->whereIn('status', ['pending', 'approved', 'rejected', 'on_hold'])
                            ->latest()
                            ->limit(6)
                            ->get();

                        // Sort: pending first, then by date
                        $sortedNotifs = $pendingCashierNotifs->sortBy(function ($notif) {
                            return $notif->status === 'pending' ? 0 : 1;
                        });

                        $cashierNotifCount = \App\Models\StockRequest::where('cashier_id', auth()->id())
                            ->where('created_at', '>=', now()->subDays(30))
                            ->whereIn('status', ['pending', 'approved', 'rejected', 'on_hold'])
                            ->count();
                    @endphp

                    @forelse($sortedNotifs as $notif)
                        <div
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50/60 dark:hover:bg-zinc-800/30 transition-colors">
                            <div class="relative flex-shrink-0">
                                <div
                                    class="w-11 h-11 rounded-sm bg-gray-100 dark:bg-zinc-850 border border-gray-200/60 dark:border-zinc-800 overflow-hidden flex items-center justify-center">
                                    @if (!empty($notif->product->image))
                                        <img src="{{ $notif->product->image }}" alt="{{ $notif->product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                            alt="Placeholder" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center border-2 border-white dark:border-zinc-900
            {{ $notif->status === 'approved' ? 'bg-green-500' : ($notif->status === 'rejected' ? 'bg-red-500' : 'bg-amber-500') }}">
                                    @if ($notif->status === 'approved')
                                        <x-heroicon-s-check class="w-2.5 h-2.5 text-white" />
                                    @elseif($notif->status === 'rejected')
                                        <x-heroicon-s-x-mark class="w-2.5 h-2.5 text-white" />
                                    @else
                                        <x-heroicon-s-clock class="w-2.5 h-2.5 text-white" />
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 space-y-0.5">
                                <p class="text-xs text-gray-800 dark:text-zinc-200 leading-snug break-words">
                                    <span class="font-bold">{{ $notif->quantity_requested }}x</span>
                                    <span
                                        class="font-medium text-xs text-gray-900 dark:text-zinc-100">{{ $notif->product->name }}</span>
                                </p>
                                <p
                                    class="text-xs font-normal tracking-normal mt-1
            {{ $notif->status === 'approved' ? 'text-green-600' : ($notif->status === 'rejected' ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ $notif->status === 'approved' ? 'Approved' : ($notif->status === 'rejected' ? 'Rejected' : ($notif->status === 'on_hold' ? 'On Hold' : 'Pending')) }}
                                </p>
                                <p class="text-[11px] text-gray-400 dark:text-zinc-500 font-medium pt-0.5">
                                    {{ $notif->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-12 text-center text-xs font-medium text-gray-400 dark:text-zinc-500">
                            <x-heroicon-o-bell-slash class="w-6 h-6 mx-auto mb-2 opacity-60" />
                            No notifications
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-9 h-9 bg-[#0F6E8C] text-white rounded-full flex items-center justify-center font-semibold">
                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
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
