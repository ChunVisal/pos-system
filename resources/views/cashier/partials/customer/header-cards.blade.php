{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">My Customers</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Customers who purchased from you</p>
    </div>  
        <a href="{{ route('cashier.customers.export') }}"
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
            Export
        </a>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">

    @foreach ($summaryCards as $card)
        <div
            class="bg-white dark:bg-zinc-900 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 p-4 flex flex-col justify-between hover:shadow-md transition-all">

            {{-- Top Row --}}
            <div class="flex items-center justify-start gap-2 mb-2">
                <div class="rounded-md p-2 px-3 shrink-0" style="background-color: {{ $card['iconBg'] }}20;">
                    <i class="{{ $card['icon'] }} text-[16px]" style="color: {{ $card['iconColor'] }};"></i>
                </div>

                {{-- Label --}}
                <h2 class=" font-bold tracking-wider text-gray-600 dark:text-zinc-400 uppercase tracking-wider mt-2">
                    {{ $card['title'] }}</h2>

            </div>

            <h2 class="py-0.5 text-2xl font-bold text-gray-800 dark:text-zinc-100">{{ $card['value'] }}</h2>
            {{-- Value --}}
            <div class="flex items-center text-center justify-start gap-1">
                <span class="text-xs font-semibold {{ $card['trendColor'] }} flex items-center">
                    <i class="fa-solid fa-arrow-trend-up text-[10px] mr-1"></i>
                    {{ $card['trend'] }}
                </span>
                <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $card['subtitle'] }}</p>

            </div>

        </div>
    @endforeach
</div>
