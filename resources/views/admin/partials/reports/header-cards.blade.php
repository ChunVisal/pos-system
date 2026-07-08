<!-- Title + Date Range + Export -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Reports</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Sales, inventory, and staff performance insights</p>
    </div>
    <div class="flex items-center gap-2 mt-3 sm:mt-0">
        <div class="relative">
            <select
                class="bg-white dark:bg-zinc-900 appearance-none text-xs border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                <option class="bg-white dark:bg-zinc-900">Today</option>
                <option class="bg-white dark:bg-zinc-900">Yesterday</option>
                <option selected class="bg-white dark:bg-zinc-900">Last 7 Days</option>
                <option class="bg-white dark:bg-zinc-900">This Month</option>
                <option class="bg-white dark:bg-zinc-900">Last Month</option>
                <option class="bg-white dark:bg-zinc-900">Custom Range</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
        <button
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-m-arrow-down-tray class="w-4 h-4" />
            Export
        </button>
    </div>
</div>

<!-- Summary Cards (LOOP) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    @foreach ($summaryCards as $card)
        <div
            class="bg-white dark:bg-zinc-900 p-3 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 flex flex-col justify-between h-32">
            <div class="flex items-center gap-2">
                <div class="rounded-md p-2 px-3" style="background-color: {{ $card['iconBg'] }}20;">
                    <i class="{{ $card['icon'] }} text-[18px]" style="color: {{ $card['iconColor'] }};"></i>
                </div>
                <p class="font-bold tracking-wider text-gray-600 dark:text-zinc-400 uppercase">{{ $card['title'] }}</p>
            </div>
            <div class="flex flex-col items-start">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-zinc-100">{{ $card['value'] }}</h2>
                <div class="flex items-center gap-1 text-xs">
                    <span
                        class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                        <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i>
                        {{ $card['percentage'] }}
                    </span>
                    <span class="text-gray-600 dark:text-zinc-400">{{ $card['period'] }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
