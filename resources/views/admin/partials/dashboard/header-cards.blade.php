
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Dashboard</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Welcome back, {{ auth()->user()->name }}</p>
    </div>
    <div class="flex items-center gap-3 mt-3 sm:mt-0">
        <div
            class="bg-white dark:bg-zinc-900 flex items-center text-xs gap-2 px-3 py-2 border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition cursor-pointer">
            <i class="fa-regular fa-calendar text-gray-800 dark:text-zinc-200"></i>
            <span class="text-xs text-gray-700 dark:text-zinc-300">Nov 19, 2023 - Nov 26, 2023</span>
            <i class="fa-solid fa-chevron-down text-gray-700 dark:text-zinc-400"></i>
        </div>
        <button
            class="bg-white dark:bg-zinc-900 text-gray-600 dark:text-zinc-300 flex text-center gap-2 px-3 py-2 text-xs border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> Export
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    @foreach ($cards as $card)
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
                <button class="text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-200">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
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
