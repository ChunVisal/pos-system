<div x-show="viewOpen" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <div x-show="viewOpen" x-transition.opacity @click="closeView()"
        class="absolute inset-0 bg-gray-900/40 dark:bg-black/60"></div>

    <div x-show="viewOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-zinc-900 shadow-xl flex flex-col">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-zinc-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-zinc-100">Customer Details</h2>
            <button @click="closeView()"
                class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-4">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-lg font-semibold text-white shrink-0"
                    style="background: linear-gradient(135deg, #0F6E8C, #1a8aa8);">
                    <span x-text="viewCustomerData.initials"></span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-zinc-100" x-text="viewCustomerData.name"></h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400" x-text="viewCustomerData.email"></p>
                    <p class="text-sm text-gray-500 dark:text-zinc-400" x-text="viewCustomerData.phone"></p>
                    <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full"
                        :class="viewCustomerData.segmentClass" x-text="viewCustomerData.segmentLabel"></span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 text-center">
                    <p class="text-xs text-gray-500 dark:text-zinc-400">Total Orders</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-zinc-100" x-text="viewCustomerData.orders"></p>
                </div>
                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 text-center">
                    <p class="text-xs text-gray-500 dark:text-zinc-400">Total Spent</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-zinc-100"
                        x-text="'$' + viewCustomerData.total_spent"></p>
                </div>
                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 text-center">
                    <p class="text-xs text-gray-500 dark:text-zinc-400">Loyalty Points</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-zinc-100"
                        x-text="viewCustomerData.loyalty_points"></p>
                </div>
            </div>

            <h4 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-3">Recent Orders</h4>
            <div class="space-y-2">
                <template x-for="order in viewCustomerData.recent_orders" :key="order.id">
                    <div
                        class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-zinc-200"
                                x-text="'Order #' + order.id"></p>
                            <p class="text-xs text-gray-400 dark:text-zinc-500" x-text="order.date"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800 dark:text-zinc-200"
                                x-text="'$' + order.amount"></p>
                            <span class="text-xs text-gray-400 dark:text-zinc-500" x-text="order.status"></span>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-6 flex gap-2">
                <button @click="openEditFromView()"
                    class="flex-1 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                    Edit Customer
                </button>
                <button
                    class="flex-1 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                    View All Orders
                </button>
            </div>
        </div>
    </div>
</div>
