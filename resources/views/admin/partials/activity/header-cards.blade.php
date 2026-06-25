<!-- Title + Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Activity & Audit Logs</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Track all user actions and system changes across your store
        </p>
    </div>
    <div class="flex items-center gap-2 mt-3 sm:mt-0">
        <button @click="refreshLogs()"
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <i class="fa-solid fa-rotate"></i> Refresh
        </button>
        <button
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-m-arrow-down-tray class="w-4 h-4" />
            Export Logs
        </button>
        <button
            class="bg-red-50 dark:bg-red-900/20 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-md hover:bg-red-100 dark:hover:bg-red-900/30 transition">
            <i class="fa-solid fa-trash-can"></i> Clear Logs
        </button>
    </div>
</div>

<!-- Summary Cards (LOOP) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    @foreach ($summary as $card)
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
            <div class="items-start gap-2">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-zinc-100">{{ $card['value'] }}</h2>
                <div class="flex text-center gap-1">
                    @if (isset($card['trend']))
                        <span
                            class="text-xs font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }}">
                            <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i> {{ $card['percentage'] }}
                        </span>
                    @endif
                    @if (isset($card['period']))
                        <span class="text-xs text-gray-500 dark:text-zinc-400">{{ $card['period'] }}</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
