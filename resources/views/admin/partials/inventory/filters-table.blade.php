<!-- Filters (Kept exactly to your design layout) -->
<div class="flex flex-wrap items-center gap-3 mb-4">
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input type="text" placeholder="Search by product name or code..."
            class="w-full pl-8 pr-3 py-1.5 text-xs bg-white dark:bg-zinc-900 text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
    </div>
    <div class="relative">
        <select
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->code }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <x-heroicon-o-chevron-down
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none" />
    </div>
    <div class="relative">
        <select
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            <option value="">All Stock Status</option>
            <option value="low">Low Stock</option>
            <option value="out">Out of Stock</option>
            <option value="normal">In Stock</option>
        </select>
        <x-heroicon-o-chevron-down
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none" />
    </div>
    <button @click="openAdjust()"
        class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-medium text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
        <i class="fa-solid fa-plus"></i> Stock Adjustment
    </button>
</div>

<!-- Stock Table -->
<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 mb-4">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800 whitespace-nowrap">
                    <th class="pb-2 pr-4 font-medium">Product</th>
                    <th class="pb-2 px-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-center">Current Stock</th>
                    <th class="pb-2 px-4 font-medium text-center">Reorder Level</th>
                    <th class="pb-2 px-4 font-medium text-center">Status</th>
                    <th class="pb-2 px-4 font-medium">Last Updated</th>
                    <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxolXBpybqOuVoJXLQE2SB0buq-Gq48WnKnB0h9AD5hKYyruRDcNa0ZNXJ&s=10' }}"
                                    class="w-12 h-12 bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/20 rounded-xs shrink-0 object-cover" />
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-zinc-200 line-clamp-3">
                                        {{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-zinc-500">{{ $product->code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 pl-4 text-gray-600 dark:text-zinc-400 whitespace-nowrap">
                            {{ $product->category->name ?? 'Unassigned' }}
                        </td>
                        <td class="py-3 text-center font-semibold text-gray-800 dark:text-zinc-100">
                            {{ $product->stock_quantity }}
                        </td>
                        <td class="py-3 text-center text-gray-500 dark:text-zinc-400">
                            {{ $product->low_stock_threshold }}
                        </td>
                        <td class="py-3 text-center whitespace-nowrap">
                            @if ($product->stock_quantity <= 0)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">Out
                                    of stock</span>
                            @elseif($product->stock_quantity < $product->low_stock_threshold)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">Low
                                    stock</span>
                            @else
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 dark:bg-green-950/40 text-green-600 dark:text-green-400">In
                                    stock</span>
                            @endif
                        </td>
                        <td class="py-3 pl-4 text-gray-500 dark:text-zinc-500 text-xs whitespace-nowrap">
                            {{ $product->updated_at->format('H:i, M d, Y') }}
                        </td>
                        <td class="py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click='openAdjust(@json($product))'
                                    class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C] dark:hover:text-[#0F6E8C]"
                                    title="Adjust Stock">
                                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 dark:text-zinc-500 text-sm">No
                            inventory items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
