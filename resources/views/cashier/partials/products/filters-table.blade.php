{{-- resources/views/cashier/partials/products/filters-table.blade.php --}}
{{-- Filter Bar --}}
<div class="flex flex-wrap items-center gap-3 mb-4">

    {{-- Search --}}
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input id="search" type="text" x-model="searchQuery" value="{{ request('search') }}"
            placeholder="Search by name, categories, code, or barcode..."
            class="w-full pl-8 pr-8 py-1.5 text-xs bg-white dark:bg-zinc-900 text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md focus:outline-none focus:ring-1 focus:ring-p placeholder-gray-400 dark:placeholder-zinc-500">
        <button type="button" id="clearSearch" style="display:none;"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 z-10">
            ✕
        </button>
    </div>

    {{-- Category --}}
    <div class="relative">
        <select x-model="filterCategory"
            class="bg-white dark:bg-zinc-900 bg-none appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-p cursor-pointer">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">
                    {{ $category->name }} ({{ (int) $category->cashier_remaining }})
                </option>
            @endforeach
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Stock --}}
    <div class="relative">
        <select x-model="filterStock"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-p cursor-pointer">
            <option value="all">All Stock</option>
            <option value="out">Out of Stock</option>
            <option value="low">Low Stock</option>
            <option value="in">In Stock</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</div>

{{-- Table --}}
<div
    class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr
                class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                <th class="py-3 pl-4 pr-2 font-medium">Product</th>
                <th class="py-3 px-2 font-medium">Category</th>
                <th class="py-3 px-2 font-medium text-center">Allocated</th>
                <th class="py-3 px-2 font-medium text-center">Sold</th>
                <th class="py-3 px-2 font-medium text-center">Remaining</th>
                <th class="py-3 px-2 font-medium text-right">Price</th>
                <th class="py-3 px-2 font-medium text-right">Revenue</th>
                <th class="py-3 font-medium text-center">Last Drop</th>
                <th class="py-3 pr-4 pl-2 font-medium text-center">Status</th>
                <th class="py-3 pr-4 pl-2 font-medium text-center">Report</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="product in filteredProducts" :key="product.id">
                <tr class="tab-container overflow-x-auto hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-3">
                            <img :src="product.image ??
                                'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png'"
                                class="w-12 h-12 rounded-sm object-cover bg-gray-100 dark:bg-zinc-800 shrink-0">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 dark:text-zinc-200 truncate max-w-[250px]"
                                    x-text="product.name"></p>
                                <p class="text-[11px] text-gray-400" x-text="product.code"></p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-2 text-xs text-gray-500 dark:text-zinc-400" x-text="product.category_name"></td>
                    <td class="py-3 px-2 text-center text-gray-700 dark:text-zinc-300 font-medium"
                        x-text="product.allocated"></td>
                    <td class="py-3 px-2 text-center text-red-500 font-medium" x-text="product.sold"></td>
                    <td class="py-3 px-2 text-center font-bold text-green-600" x-text="product.remaining"></td>
                    <td class="py-3 px-2 text-right font-semibold text-[#0F6E8C]"
                        x-text="'$' + Number(product.selling_price).toFixed(2)"></td>
                    <td class="py-3 px-2 text-right font-semibold text-purple-600"
                        x-text="'$' + Number(product.revenue).toFixed(2)"></td>
                    <td class="py-3 px-2 text-xs text-center text-gray-500"
                        x-text="product.last_drop ? new Date(product.last_drop).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) : '-'">
                    </td>
                    <td class="py-3 pr-4 pl-2 text-center">
                        <span class="px-2 py-0.5 text-[10px] rounded-full font-medium"
                            :class="product.remaining > 5 ?
                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' :
                                (product.remaining > 0 ?
                                    'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' :
                                    'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400')"
                            x-text="product.remaining > 5 ? 'In Stock' : (product.remaining > 0 ? 'Low Stock' : 'Out of Stock')">
                        </span>
                    </td>
                    <td>
                        <button @click="reportLoss(product.id, product.name, product.remaining)"
                            class="text-[14px] font-medium text-red-500 hover:text-red-600 transition-colors shrink-0">
                            Report Loss
                        </button>
                    </td>
                </tr>
            </template>

            <template x-if="filteredProducts.length === 0">
                <tr>
                    <td colspan="9" class="text-center py-20 bg-white dark:bg-zinc-900">
                        <div class="max-w-xs mx-auto flex flex-col items-center justify-center">
                            {{-- Stacked empty-box icon container matching premium system theme --}}
                            <div
                                class="w-14 h-14 rounded-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-150 dark:border-zinc-800 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-gray-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                            {{-- Structured typography layout --}}
                            <p class="text-md font-bold text-gray-900 dark:text-zinc-200 uppercase tracking-wider">
                                No matching products
                            </p>
                            <p class="text-[12px] text-gray-400 dark:text-zinc-500 mt-1 max-w-[190px] leading-relaxed">
                                Try adjusting your search criteria or filters to locate items.
                            </p>
                        </div>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
