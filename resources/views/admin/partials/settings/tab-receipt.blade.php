<!-- RECEIPT -->
<div id="settings-receipt" class="settings-panel hidden">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Receipt Settings</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Customize what prints on customer receipts</p>

    <div class="max-w-2xl space-y-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Header Text</label>
            <textarea rows="2"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">{{ $receipt['header_text'] }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Footer Text</label>
            <textarea rows="2"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">{{ $receipt['footer_text'] }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Paper Size</label>
                <div class="relative">
                    <select
                        class="appearance-none w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                        <option class="bg-white dark:bg-zinc-900"
                            {{ $receipt['paper_size'] === '58mm' ? 'selected' : '' }}>58mm</option>
                        <option class="bg-white dark:bg-zinc-900"
                            {{ $receipt['paper_size'] === '80mm' ? 'selected' : '' }}>80mm</option>
                        <option class="bg-white dark:bg-zinc-900">A4</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end">
                <div
                    class="flex items-center justify-between w-full border border-gray-200 dark:border-zinc-700 rounded-md px-3 py-2">
                    <span class="text-xs font-medium text-gray-600 dark:text-zinc-400">Show Logo on Receipt</span>
                    <button type="button"
                        class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $receipt['show_logo'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                        <span
                            class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $receipt['show_logo'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <button
            class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">Save
            Changes</button>
    </div>
</div>
