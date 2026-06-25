<!-- TOP ITEMS TAB -->
<div id="tab-items" class="report-panel p-4 hidden">
    <div class="tab-container ">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium w-10">Rank</th>
                    <th class="pb-2 px-4 font-medium">Product</th>
                    <th class="pb-2 px-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-center">Qty Sold</th>
                    <th class="pb-2 px-4 font-medium text-right">Revenue</th>
                    <th class="pb-2 pl-4 font-medium w-40">Share</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @foreach ($topItems as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4">
                            <span
                                class="text-sm font-bold {{ $item['rank'] === 1 ? 'text-yellow-500' : 'text-gray-500 dark:text-zinc-500' }}">#{{ $item['rank'] }}</span>
                        </td>
                        <td class="py-3 px-4 font-medium text-gray-800 dark:text-zinc-200">{{ $item['name'] }}</td>
                        <td class="py-3 px-4 text-gray-600 dark:text-zinc-400">{{ $item['category'] }}</td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $item['qty_sold'] }}</td>
                        <td class="py-3 px-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                            ${{ number_format($item['revenue'], 2) }}</td>
                        <td class="py-3 pl-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-200 dark:bg-zinc-800 rounded-full">
                                    <div class="h-1.5 bg-[#0F6E8C] rounded-full"
                                        style="width: {{ $item['percent'] }}%;"></div>
                                </div>
                                <span
                                    class="text-xs text-gray-400 dark:text-zinc-500 w-8 text-right">{{ $item['percent'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
