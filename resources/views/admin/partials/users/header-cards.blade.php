<!-- Title + Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Users</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Manage admin and cashier accounts</p>
    </div>
    <div class="flex items-center gap-2 mt-3 sm:mt-0">
        <button @click="openAdd()"
            class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
            <i class="fa-solid fa-plus"></i> Add User
        </button>
        <button
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export
        </button>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    @foreach ($summaryCards as $card)
        <div
            class="bg-white dark:bg-zinc-900 p-3 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 flex flex-col justify-between relative overflow-hidden h-32">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3"
                        style="background-color: {{ $card['iconBg'] === 'transparent' ? 'transparent' : $card['iconBg'] . '20' }};">
                        <i class="{{ $card['icon'] }} text-[18px]" style="color: {{ $card['iconColor'] }};"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 dark:text-zinc-400 uppercase">{{ $card['title'] }}</p>
                </div>
            </div>
            <div class="flex flex-col items-start gap-1">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-zinc-100">{{ $card['value'] }}</h2>
                <div class="flex items-center gap-1 text-xs">
                    <span
                        class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                        <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i> {{ $card['percentage'] }}
                    </span>
                    <span class="text-gray-600 dark:text-zinc-400">{{ $card['period'] }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
