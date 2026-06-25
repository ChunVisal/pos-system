<!-- TAX & CURRENCY -->
<div id="settings-tax" class="settings-panel hidden">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Tax & Currency</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Controls how prices and tax are calculated at checkout</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Currency</label>
            <div class="relative">
                <select
                    class="appearance-none w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                    <option class="bg-white dark:bg-zinc-900" {{ $taxCurrency['currency'] === 'USD' ? 'selected' : '' }}>
                        USD ($)</option>
                    <option class="bg-white dark:bg-zinc-900" {{ $taxCurrency['currency'] === 'KHR' ? 'selected' : '' }}>
                        KHR (៛)</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Tax Rate (%)</label>
            <input type="number" step="0.01" value="{{ $taxCurrency['tax_rate'] }}"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-2">Tax Mode</label>
            <div class="grid grid-cols-2 gap-2 max-w-sm">
                <button type="button"
                    class="tax-mode-btn py-2 rounded-md text-xs font-semibold border {{ $taxCurrency['tax_mode'] === 'exclusive' ? 'bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/30 border-[#0F6E8C] text-[#0F6E8C]' : 'border-gray-300 dark:border-zinc-700 text-gray-500 dark:text-zinc-400 hover:bg-gray-50 dark:hover:bg-zinc-800' }}">
                    Tax Exclusive
                </button>
                <button type="button"
                    class="tax-mode-btn py-2 rounded-md text-xs font-semibold border {{ $taxCurrency['tax_mode'] === 'inclusive' ? 'bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/30 border-[#0F6E8C] text-[#0F6E8C]' : 'border-gray-300 dark:border-zinc-700 text-gray-500 dark:text-zinc-400 hover:bg-gray-50 dark:hover:bg-zinc-800' }}">
                    Tax Inclusive
                </button>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-zinc-500 mt-1.5">Exclusive adds tax on top of the listed
                price; inclusive means tax is already part of it.</p>
        </div>
    </div>

    <div class="mt-5">
        <button
            class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">Save
            Changes</button>
    </div>
</div>
