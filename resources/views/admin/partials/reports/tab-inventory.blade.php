<!-- INVENTORY TAB -->
<div id="tab-inventory" class="report-panel p-4 hidden">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 border border-gray-200 dark:border-zinc-700">
            <p class="text-xs text-gray-500 dark:text-zinc-400 mb-1">Total Stock Value</p>
            <p class="text-xl font-bold text-gray-800 dark:text-zinc-100">
                ${{ number_format($inventorySummary['total_stock_value']) }}</p>
        </div>
        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 border border-gray-200 dark:border-zinc-700">
            <p class="text-xs text-gray-500 dark:text-zinc-400 mb-1">Low Stock Items</p>
            <p class="text-xl font-bold text-amber-600 dark:text-amber-400">{{ $inventorySummary['low_stock'] }}</p>
        </div>
        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-md p-3 border border-gray-200 dark:border-zinc-700">
            <p class="text-xs text-gray-500 dark:text-zinc-400 mb-1">Out of Stock</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $inventorySummary['out_of_stock'] }}</p>
        </div>
    </div>

    <h4 class="text-xs font-semibold text-gray-600 dark:text-zinc-400 uppercase mb-2">Stock Value by Category</h4>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-center">Products</th>
                    <th class="pb-2 px-4 font-medium text-center">Units in Stock</th>
                    <th class="pb-2 pl-4 font-medium text-right">Stock Value</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @foreach ($stockByCategory as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4 font-medium text-gray-800 dark:text-zinc-200">{{ $row['category'] }}</td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $row['products'] }}</td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $row['total_stock'] }}
                        </td>
                        <td class="py-3 pl-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                            ${{ number_format($row['stock_value'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
