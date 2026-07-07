{{-- resources/views/admin/partials/customers/customer-detail.blade.php --}}
<div x-show="customerDetailOpen" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <div @click="customerDetailOpen = false" class="absolute inset-0 bg-black/50"></div>

    <div @click.stop x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-zinc-900 shadow-xl flex flex-col">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-800">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#0F6E8C] to-[#1a8aa8] flex items-center justify-center text-white text-xl font-bold shadow-lg"
                        x-text="customerProfile.name?.charAt(0)?.toUpperCase()"></div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-zinc-100" x-text="customerProfile.name">
                        </h3>
                        <p class="text-xs text-gray-500">
                            Joined: <span
                                x-text="customerProfile.created_at ? new Date(customerProfile.created_at).toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'}) : '-'"></span>
                        </p>
                        <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-bold rounded-full"
                            :class="customerProfile.total_orders >= 6 || customerProfile.total_spent >= 5000 ?
                                'bg-yellow-100 text-yellow-700' :
                                (customerProfile.total_orders >= 3 || customerProfile.total_spent >= 2000 ?
                                    'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700')"
                            x-text="customerProfile.total_orders >= 6 || customerProfile.total_spent >= 5000 ? 'VIP' : 
                                   (customerProfile.total_orders >= 3 || customerProfile.total_spent >= 2000 ? 'REGULAR' : 'NEW')"></span>
                    </div>
                </div>
                <button @click="customerDetailOpen = false"
                    class="w-8 h-8 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-6">

            {{-- Contact Card --}}
            <div class="bg-gray-50 dark:bg-zinc-800 rounded-xl p-4">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Contact Info</h4>
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-950 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-blue-600 text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-800 dark:text-zinc-200" x-text="customerProfile.phone"></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-950 flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-green-600 text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-800 dark:text-zinc-200"
                            x-text="customerProfile.email || 'No email'"></span>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 gap-3">
                <div
                    class="bg-gradient-to-br from-[#0F6E8C]/5 to-[#0F6E8C]/10 dark:from-[#0F6E8C]/10 dark:to-[#0F6E8C]/20 rounded-xl p-4 text-center">
                    <i class="fa-solid fa-receipt text-[#0F6E8C] text-xl mb-2"></i>
                    <p class="text-2xl font-bold text-[#0F6E8C]" x-text="customerProfile.total_orders"></p>
                    <p class="text-[11px] text-gray-500 mt-1">Total Orders</p>
                </div>
                <div
                    class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/20 dark:to-green-950/30 rounded-xl p-4 text-center">
                    <i class="fa-solid fa-dollar-sign text-green-600 text-xl mb-2"></i>
                    <p class="text-2xl font-bold text-green-600">$<span
                            x-text="parseFloat(customerProfile.total_spent || 0).toFixed(0)"></span></p>
                    <p class="text-[11px] text-gray-500 mt-1">Total Spent</p>
                </div>
                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-950/20 dark:to-purple-950/30 rounded-xl p-4 text-center">
                    <i class="fa-solid fa-chart-line text-purple-600 text-xl mb-2"></i>
                    <p class="text-2xl font-bold text-purple-600">$<span
                            x-text="(parseFloat(customerProfile.total_spent || 0) / (customerProfile.total_orders || 1)).toFixed(0)"></span>
                    </p>
                    <p class="text-[11px] text-gray-500 mt-1">Avg Order</p>
                </div>
                <div
                    class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-950/20 dark:to-amber-950/30 rounded-xl p-4 text-center">
                    <i class="fa-solid fa-clock text-amber-600 text-xl mb-2"></i>
                    <p class="text-sm font-bold text-amber-600"
                        x-text="customerProfile.last_order_at ? new Date(customerProfile.last_order_at).toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'}) : 'Never'">
                    </p>
                    <p class="text-[11px] text-gray-500 mt-1">Last Order</p>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Recent Orders</h4>
                <div class="space-y-2">
                    <template x-for="order in customerOrders" :key="order.id">
                        <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-gray-800 dark:text-zinc-200"
                                    x-text="order.order_number"></span>
                                <span class="text-xs font-bold text-[#0F6E8C]">$<span
                                        x-text="parseFloat(order.total).toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-500 mb-2">
                                {{-- <span
                                    x-text="new Date(order.created_at).toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'2-digit', minute:'2-digit'})"></span>
                                <span class="capitalize px-2 py-0.5 rounded-full text-[10px]" --}}
                                    :class="order.payment?.method === 'cash' ? 'bg-green-100 text-green-700' : order.payment
                                        ?.method === 'card' ? 'bg-blue-100 text-blue-700' :
                                        'bg-purple-100 text-purple-700'"
                                    x-text="order.payment?.method || '-'"></span>
                            </div>
                            {{-- Items --}}
                            <div class="space-y-1 pt-2 border-t border-gray-200 dark:border-zinc-700">
                                <template x-for="item in order.items" :key="item.id">
                                    <div class="flex justify-between text-[11px] text-gray-500">
                                        <span x-text="item.quantity + 'x ' + item.name"></span>
                                        <span>$<span x-text="parseFloat(item.total).toFixed(2)"></span></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <div x-show="customerOrders.length === 0" class="text-center py-8 text-xs text-gray-400">
                        No orders yet
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800/30">
            <button @click="customerDetailOpen = false"
                class="w-full py-2.5 text-sm font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-600 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition">
                Close
            </button>
        </div>
    </div>
</div>
