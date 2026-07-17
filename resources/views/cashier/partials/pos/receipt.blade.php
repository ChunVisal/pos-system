{{-- resources/views/cashier/partials/pos/receipt.blade.php --}}
<div x-show="receiptOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    {{-- Overlay --}}
    <div @click="receiptOpen = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    {{-- Receipt Card --}}
    <div class="relative w-full max-w-sm bg-white dark:bg-zinc-900 rounded-lg shadow-2xl overflow-hidden">

        {{-- Receipt Paper --}}
        <div class="p-6 font-mono text-sm">

            {{-- Header --}}
            <div class=" text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="POS Technology Logo" class="mx-auto h-12 w-auto mb-2" />

                <p class="text-[10px] text-gray-500 dark:text-zinc-300 mt-0.5">123 Monivong Blvd, Phnom Penh</p>
                <p class="text-[10px] text-gray-500 dark:text-zinc-300">Tel: 012 345 678</p>
                <div class="border-t border-dashed border-gray-300 dark:border-zinc-700 my-3"></div>

            </div>

            {{-- Order Info --}}
            <div class="space-y-1 text-xs mb-3">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-zinc-300">Order:</span>
                    <span class="font-semibold text-gray-800 dark:text-zinc-200" x-text="lastOrder.order_number"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-zinc-300">Date:</span>
                    <span class="text-gray-800 dark:text-zinc-200" x-text="new Date().toLocaleDateString()"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-zinc-300">Time:</span>
                    <span class="text-gray-800 dark:text-zinc-200" x-text="new Date().toLocaleTimeString()"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-zinc-300">Cashier:</span>
                    <span class="text-gray-800 dark:text-zinc-200">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-zinc-300">Customer:</span>
                    <span class="text-gray-500 dark:text-zinc-300"
                        x-text="(receiptData.customer?.name || 'Cash') + ' - ' + (receiptData.payment_method === 'cash' ? 'Cash' : receiptData.payment_method === 'card' ? 'Card' : 'KHQR')"></span>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-300 dark:border-zinc-700 my-3"></div>

            {{-- Items --}}
            <div class="space-y-1.5 mb-3">
                <template x-for="item in receiptData.items" :key="item.id">
                    <div class="flex justify-between text-xs">
                        <span class="flex-1 truncate dark:text-zinc-200">
                            <span x-text="item.qty"></span>x <span x-text="item.name"></span>
                        </span>
                        <span class="font-semibold ml-2 dark:text-zinc-200">$<span
                                x-text="(item.price * item.qty).toFixed(2)"></span></span>
                    </div>
                </template>
            </div>

            <div class="border-t border-dashed border-gray-300 dark:border-zinc-700 my-3"></div>

            {{-- Totals --}}
            <div class="flex justify-between dark:text-zinc-300">
                <span class="text-gray-500 dark:text-zinc-300">Subtotal</span>
                <span>$<span x-text="receiptData.subtotal?.toFixed(2) || '0.00'"></span></span>
            </div>
            <div class="flex justify-between dark:text-zinc-300" x-show="receiptData.discount > 0">
                <span class="text-gray-500 dark:text-zinc-300">Discount</span>
                <span>-$<span x-text="(receiptData.discount || 0).toFixed(2)"></span></span>
            </div>
            <div x-show="receiptData.is_vip" class="flex justify-between text-sm text-yellow-600">
                <span class="text-gray-500 dark:text-zinc-300">VIP Discount (5%)</span>
                <span>-$<span x-text="(receiptData.vip_discount || 0).toFixed(2)"></span></span>
            </div>
            <div class="flex justify-between dark:text-zinc-300">
                <span class="text-gray-500 ">Tax (10%)</span>
                <span>$<span x-text="receiptData.tax?.toFixed(2) || '0.00'"></span></span>
            </div>
            <div class="flex justify-between text-base font-bold border-t pt-1 mt-1 dark:text-zinc-200">
                <span>TOTAL</span>
                <span class="text-[#0F6E8C]">$<span x-text="receiptData.total?.toFixed(2) || '0.00'"></span></span>
            </div>

            <div class="border-t border-dashed border-gray-300 dark:border-zinc-700 my-3"></div>

            {{-- Payment --}}
            <span class="dark:text-zinc-300 font-semibold capitalize" x-text="receiptData.payment_method"></span>
            <span class="dark:text-zinc-300" x-show="receiptData.payment_method === 'cash'">$<span
                    x-text="parseFloat(receiptData.amount_received || 0).toFixed(2)"></span></span>
            <span class="dark:text-zinc-300" x-show="receiptData.change > 0">Change $<span
                    x-text="receiptData.change?.toFixed(2)"></span></span>

            <div class="border-t border-dashed border-gray-300 dark:border-zinc-700 my-3"></div>

            {{-- Footer --}}
            <div class="text-center text-[10px] text-gray-400 space-y-1">
                <div class="flex items-center justify-center gap-1.5 mb-1">
                    <span class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                        <i class="fa-solid fa-check text-[10px] text-white"></i>
                    </span>
                    <span class="text-green-600 dark:text-green-400 font-medium">Payment Completed</span>
                </div>
                <p>Thank you for your purchase!</p>
                <p class="mt-2">***</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-800 flex gap-3 bg-gray-50 dark:bg-zinc-800/50">
            <button
                @click="receiptOpen = false; cartItems = []; amountReceived = ''; change = 0; paymentMethod = 'cash';"
                class="flex-1 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                <i class="fa-solid fa-check mr-1"></i> Done
            </button>
            <button @click="window.print()"
                class="flex-1 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-600 rounded-md hover:bg-white dark:hover:bg-zinc-700 transition">
                <i class="fa-solid fa-print mr-1"></i> Print
            </button>
        </div>
    </div>
</div>
