<!-- SALES TREND TAB -->
<div id="tab-sales" class="report-panel p-4">
    <div class="relative min-w-0 mb-5" style="height: 260px;">
        <canvas id="revenueTrendChart"></canvas>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Date</th>
                    <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                    <th class="pb-2 px-4 font-medium text-center">Items Sold</th>
                    <th class="pb-2 px-4 font-medium text-right">Avg Sale</th>
                    <th class="pb-2 pl-4 font-medium text-right">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @foreach ($dailySales as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4 text-gray-800 dark:text-zinc-200 font-medium">
                            {{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}
                        </td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $row['transactions'] }}
                        </td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $row['items_sold'] }}</td>
                        <td class="py-3 px-4 text-right text-gray-600 dark:text-zinc-400">
                            ${{ number_format($row['avg_sale'], 2) }}</td>
                        <td class="py-3 pl-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                            ${{ number_format($row['revenue'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
