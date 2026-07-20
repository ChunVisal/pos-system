{{-- Search + Date Filter --}}
<div x-data="orderSearch()">
    <div class="flex items-center gap-3 mb-4">
        <div class="relative flex-1">
            <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" x-model="searchQuery" @input.debounce.300="searchOrders()"
                placeholder="Search order number or customer name"
                class="text-gray-800 dark:text-zinc-100 w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 dark:border-zinc-700 rounded-md bg-white dark:bg-zinc-900">
            <button x-show="searchQuery" @click="searchQuery = ''; searchOrders()"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
        {{-- Date Filter --}}
        <div class="relative" x-data="{ open: false, selected: 'All Time' }">
            <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-1.5 text-xs border border-gray-300 dark:border-zinc-800 rounded-md bg-white dark:bg-zinc-900 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800/60 transition-colors whitespace-nowrap">
                <i class="fa-regular fa-calendar text-gray-600 dark:text-zinc-400"></i>
                <span x-text="selected"></span>
                <i class="fa-solid fa-chevron-down text-gray-400 dark:text-zinc-500 text-[10px]"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak
                class="absolute right-0 mt-1 w-40 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-md shadow-lg dark:shadow-zinc-950/50 z-20 py-1">
                <button @click="selected = 'Today'; open = false; filterDate('today')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800/60 transition-colors">Today</button>
                <button @click="selected = 'Yesterday'; open = false; filterDate('yesterday')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800/60 transition-colors">Yesterday</button>
                <button @click="selected = 'Last 7 Days'; open = false; filterDate('7days')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800/60 transition-colors">Last
                    7 Days</button>
                <button @click="selected = 'Last 30 Days'; open = false; filterDate('30days')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800/60 transition-colors">Last
                    30 Days</button>
                <button @click="selected = 'All Time'; open = false; filterDate('all')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-zinc-800/60 transition-colors">All
                    Time</button>
            </div>
        </div>

        {{-- Payment Filter --}}
        <div class="relative" x-data="{ open: false, selected: 'All Payments' }">
            <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-1.5 text-xs border border-gray-300 dark:border-zinc-700 rounded-md bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-200 whitespace-nowrap">
                <i class="fa-solid fa-credit-card text-[#1A1F7C] dark:text-zinc-400"></i>
                <span x-text="selected"></span>
                <i class="fa-solid fa-chevron-down text-gray-400 dark:text-zinc-400 text-[10px]"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak
                class="absolute right-0 mt-1 w-36 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-md shadow-lg z-20 py-1">
                <button @click="selected = 'All Payments'; open = false; filterPayment('all')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-700">All
                    Payments</button>
                <button @click="selected = 'Cash'; open = false; filterPayment('cash')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-700">Cash</button>
                <button @click="selected = 'Card'; open = false; filterPayment('card')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-700">Card</button>
                <button @click="selected = 'KHQR'; open = false; filterPayment('khqr')"
                    class="block w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-700">KHQR</button>
            </div>
        </div>
    </div>

    {{-- Orders Component Box Container --}}
    <div id="ordersTable"
        class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
        {{-- Unified Scroll Contained Table Boundary Layout matching Customer Grid --}}
        <div class="scroll-smooth table-scroll overflow-auto max-h-[600px]">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-white dark:bg-zinc-900 z-10">
                    <tr
                        class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                        <th class="pb-2 pr-4 pl-4 font-medium">Order</th>
                        <th class="pb-2 px-4 font-medium">Customer</th>
                        <th class="pb-2 px-4 font-medium text-center">Items</th>
                        <th class="pb-2 px-4 font-medium">Total</th>
                        <th class="pb-2 px-4 font-medium">Payment</th>
                        <th class="pb-2 px-4 font-medium">Date</th>
                        <th class="pb-2 pr-4 pl-2 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                    {{-- Alpine Reactive Loop Layout --}}
                    <template x-for="order in orders" :key="order.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="py-3 pl-4 pr-2 font-medium text-gray-800 dark:text-zinc-200"
                                x-text="order.order_number"></td>

                            <td class="py-3 px-4">
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-zinc-200 truncate"
                                        x-text="order.customer?.name || 'Walk-in'"></p>
                                    <p class="text-xs text-gray-400 truncate" x-text="order.customer?.phone || ''"></p>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-center font-medium text-gray-700 dark:text-zinc-300"
                                x-text="order.items.reduce((sum, i) => sum + (i.quantity || 0), 0)"></td>

                            <td class="font-medium text-gray-800 dark:text-zinc-300"
                                x-text="'$' + (order.total ? parseFloat(order.total).toFixed(2) : '0.00')"></td>

                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full uppercase"
                                    :class="{
                                        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': order
                                            .payment?.method === 'cash',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': order
                                            .payment?.method === 'card',
                                        'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400': order
                                            .payment?.method === 'khqr'
                                    }"
                                    x-text="order.payment?.method || 'CASH'"></span>
                            </td>

                            <td class="text-gray-800 dark:text-zinc-300"
                                x-text="order.created_at ? new Date(order.created_at).toLocaleDateString('en-US', {month:'short', day:'numeric', hour:'2-digit', minute:'2-digit'}) : '-'">
                            </td>

                            <td class="py-3 pr-4 pl-2 text-right">
                                <button @click="viewOrder(order.id)" class="text-yellow-400 hover:text-yellow-500">
                                    <i class="fa-solid fa-receipt text-lg"></i>
                                </button>
                                <button x-show="order.status === 'completed'" @click="refundOrder(order.id)"
                                    class="text-xs font-medium text-red-500 hover:text-red-600 ml-2">
                                    Refund
                                </button>
                                <span x-show="order.status === 'refunded'"
                                    class="text-xs ml-1 font-medium text-green-600">Refunded</span>
                            </td>
                        </tr>
                    </template>
                    {{-- Not Found - shows for any filter --}}
                    <tr x-show="orders.length === 0">
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center justify-center">
                                <div
                                    class="w-14 h-14 mb-3 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-receipt text-xl text-gray-400"></i>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300">No orders found</h3>
                                <p class="text-xs text-gray-400 mt-1">Try adjusting your filters</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Redesigned Layout Pagination Row Built to Mirror Customer Control Component --}}
        @if ($orders->hasPages())
            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200 dark:border-zinc-800">
                {{-- Counter Text Meta Tracker --}}
                <p class="text-xs text-gray-500 dark:text-zinc-400">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                </p>

                {{-- Action Controls Array Row Grid Elements --}}
                <div class="flex items-center gap-1">
                    {{-- Previous Action Link Button Trigger --}}
                    @if ($orders->onFirstPage())
                        <button
                            class="px-3 py-1 text-xs border border-gray-200 dark:border-zinc-800 rounded-md text-gray-300 dark:text-zinc-600 cursor-not-allowed"
                            disabled>
                            Previous
                        </button>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}#ordersTable"
                            class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                            Previous
                        </a>
                    @endif

                    {{-- Center Numerical Row Loop Configuration Elements --}}
                    @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 4), min($orders->lastPage(), $orders->currentPage() + 6)) as $page => $url)
                        @if ($page == $orders->currentPage())
                            <button class="px-3 py-1 text-xs rounded-md bg-[#0F6E8C] text-white font-medium">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}#ordersTable"
                                class="px-3 py-1 text-xs rounded-md border border-gray-300 dark:border-zinc-700 text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Action Link Button Trigger --}}
                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}#ordersTable"
                            class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                            Next
                        </a>
                    @else
                        <button
                            class="px-3 py-1 text-xs border border-gray-200 dark:border-zinc-800 rounded-md text-gray-300 dark:text-zinc-600 cursor-not-allowed"
                            disabled>
                            Next
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>



<script>
    function orderSearch() {
        return {
            searchQuery: '',
            orders: @json($orders->items()),

            searchOrders() {
                fetch(`/cashier/orders?search=${encodeURIComponent(this.searchQuery)}&ajax=1`)
                    .then(res => res.json())
                    .then(data => {
                        this.orders = data.orders.data || data.orders || data; // ← paginator has .data
                    });
            },

            filterDate(range) {
                fetch(`/cashier/orders?range=${range}&ajax=1`)
                    .then(res => res.json())
                    .then(data => {
                        this.orders = data.orders || data;
                    });
            },

            filterPayment(method) {
                let url = `/cashier/orders?payment=${method}&ajax=1`;
                if (this.searchQuery) url += `&search=${encodeURIComponent(this.searchQuery)}`;
                fetch(url)
                    .then(res => res.json())
                    .then(data => this.orders = data.orders || data);
            },
        };
    }
</script>
