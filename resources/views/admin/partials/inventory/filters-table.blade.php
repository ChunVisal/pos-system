<!-- Filters (Kept exactly to your design layout) -->
<div class="flex flex-wrap items-center gap-3 mb-4">
    <div class="relative flex-1 id="searchSection" class="min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input id="search" type="text" value="{{ request('search') }}"
            placeholder="Search by name, categories, code, or barcode..."
            class="w-full pl-8 pr-8 py-1.5 text-xs bg-white dark:bg-zinc-900 text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md focus:outline-none focus:ring-1 focus:ring-p placeholder-gray-400 dark:placeholder-zinc-500">
        <button type="button" id="clearSearch" style="display:none;"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 z-10">
            ✕
        </button>
    </div>
    <div class="relative">
        <select id="categoryFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">{{ $category->name }} ({{ (int) $category->total_stock }})
                </option>
            @endforeach
        </select>
        <x-heroicon-o-chevron-down
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none" />
    </div>
    <div class="relative">
        <select id="stockFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            <option value="all">All Stock</option>
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
                    <th class="flex gap-1 pb-2 pr-4 font-medium">Product:<h4
                            class="font-semibold text-gray-600 dark:text-zinc-300">
                            {{ $products->sum('stock_quantity') }}</h7>
                    </th>
                    <th class="pb-2 px-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-center">Current Stock</th>
                    <th class="pb-2 px-4 font-medium text-center">Reorder Level</th>
                    <th class="pb-2 px-4 font-medium text-center">Stock</th>
                    <th class="pb-2 px-4 font-medium">Last Updated</th>
                    <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="InventoryTable" class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @include('admin.partials.inventory.table-rows')
            </tbody>

            <tr id="noCategoryRow" class="" style="display:none;">
                <td colspan="8" class="text-center py-16">
                    <div class="flex flex-col items-center justify-center">
                        {{-- Icon --}}
                        <div
                            class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>

                        {{-- Text --}}
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-1">
                            No products found in Inventory
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-zinc-500 max-w-xs">
                            Try adjusting your search or filter to find what you're looking for.
                        </p>

                        {{-- Optional: Add Product button --}}
                        <button @click="openAdd()"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            Add Your First Product
                        </button>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</div>
