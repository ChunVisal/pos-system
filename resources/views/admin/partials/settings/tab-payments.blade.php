<!-- PAYMENT METHODS -->
<div id="settings-payments" class="settings-panel hidden">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Payment Methods</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Enable or disable how customers can pay at checkout</p>

    <div class="max-w-2xl space-y-2">
        @foreach ($paymentMethods as $method)
            <div
                class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-md flex items-center justify-center"
                        style="background-color: {{ $method['color'] }}20;">
                        <i class="{{ $method['icon'] }}" style="color: {{ $method['color'] }};"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-800 dark:text-zinc-200">{{ $method['name'] }}</span>
                </div>
                <button type="button"
                    class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $method['enabled'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                    <span
                        class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $method['enabled'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
                </button>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-gray-400 dark:text-zinc-500 mt-3 max-w-2xl">
        These match the payment methods shown in your Reports → Payment Report breakdown.
    </p>

    <div class="mt-5">
        <button
            class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">Save
            Changes</button>
    </div>
</div>
