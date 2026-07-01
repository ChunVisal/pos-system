<!-- Title + Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Inventory</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Track stock levels and movement across your catalog</p>
    </div>
    <div class="flex items-center gap-2 mt-3 sm:mt-0">
        <div class="relative" x-data="{ open: false }">
            <div @click="open = !open"
                class="bg-white dark:bg-zinc-900 flex items-center text-xs gap-2 px-3 py-2 border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition cursor-pointer">
                <i class="fa-regular fa-calendar text-gray-800 dark:text-zinc-200"></i>
                <span class="text-xs text-gray-700 dark:text-zinc-300">
                    {{ \Carbon\Carbon::parse(request('start_date', now()->subDays(6)))->format('M d, Y') }}
                    -
                    {{ \Carbon\Carbon::parse(request('end_date', now()))->format('M d, Y') }}
                </span>
                <i class="fa-solid fa-chevron-down text-gray-700 dark:text-zinc-400"></i>
            </div>

            <div x-show="open" @click.outside="open = false" x-cloak
                class="absolute right-0 mt-2 w-72 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-md shadow-lg z-30 p-3">

                {{-- Presets --}}
                <div class="space-y-1 mb-3">
                    <a href="{{ route('admin.inventory', ['range' => '7']) }}"
                        class="block px-2 py-1.5 text-xs rounded hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                        Last 7 days
                    </a>
                    <a href="{{ route('admin.inventory', ['range' => '30']) }}"
                        class="block px-2 py-1.5 text-xs rounded hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                        Last 30 days
                    </a>
                    <a href="{{ route('admin.inventory', ['range' => '90']) }}"
                        class="block px-2 py-1.5 text-xs rounded hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                        Last 90 days
                    </a>
                </div>

                <div class="border-t border-gray-200 dark:border-zinc-700 pt-3">
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-zinc-400 mb-2">Custom range</p>
                    <form action="{{ route('admin.inventory') }}" method="GET" class="space-y-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full text-xs border border-gray-300 dark:border-zinc-700 rounded-md px-2 py-1.5 bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full text-xs border border-gray-300 dark:border-zinc-700 rounded-md px-2 py-1.5 bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                        <button type="submit"
                            class="w-full px-3 py-1.5 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972]">
                            Apply
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.inventory.export') }}"
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
            Export
        </a>
    </div>
</div>

<!-- Stock Movement Chart + Summary Cards -->
<div class="flex gap-2 w-full min-w-0 mb-4">
    <!-- Stock Movement Overview (chart) -->
    <div
        class="w-[65%] min-w-0 bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60 p-4">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100">Stock Movement Overview</h3>
                <p class="text-xs text-gray-400 dark:text-zinc-500">
                    Stock In vs Stock Out — {{ count($trend['labels']) }} days
                </p>
            </div>
            <div class="flex items-center gap-3 text-[11px] text-gray-500 dark:text-zinc-400">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>Stock
                    In</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#EF4444]"></span>Stock
                    Out</span>
            </div>
        </div>
        <div class="relative min-w-0" style="height: 260px;">
            <canvas id="movementTrendChart"></canvas>
        </div>
    </div>

    <!-- Summary Cards (2 col x 2 row) -->
    <div class="w-[35%] min-w-0 grid grid-cols-2 grid-rows-2 gap-2">
        @foreach ($summaryCards as $card)
            <div
                class="bg-white dark:bg-zinc-900 p-3 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 flex flex-col justify-between relative overflow-hidden">
                <div class="flex flex-col items-start gap-1.5 xl:flex-row xl:items-center 2xl:gap-2">
                    <div class="rounded-md p-2 px-3 shrink-0"
                        style="background-color: {{ $card['iconBg'] === 'transparent' ? 'transparent' : $card['iconBg'] . '20' }};">
                        <i class="{{ $card['icon'] }} text-[16px]" style="color: {{ $card['iconColor'] }};"></i>
                    </div>
                    <p class="text-[11px] font-semibold text-gray-600 dark:text-zinc-400 uppercase leading-tight">
                        {{ $card['title'] }}</p>
                </div>
                <div class="flex flex-col items-start gap-1">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-zinc-100">
                        @if ($card['title'] === 'Stock Value')
                            ${{ number_format($card['value'], 2) }}
                        @else
                            {{ number_format($card['value']) }}
                        @endif
                    </h2>
                    <div class="flex items-start gap-1 text-[12px]">
                        <span
                            class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                            <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i>
                            {{ $card['percentage'] }}
                        </span>
                        <span class="text-gray-500 dark:text-zinc-400 whitespace-nowrap">{{ $card['period'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
