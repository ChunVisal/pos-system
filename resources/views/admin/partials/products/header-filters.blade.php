{{-- Title Row --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Products</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Manage your PC component catalog and stock</p>
    </div>
    <div class="items-center flex gap-4">
        <button @click="openAdd()"
            class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-p rounded-md hover:bg-[#0c5972] transition">
            <i class="fa-solid fa-plus"></i> Add Product
        </button>
        <button
            class="bg-white dark:bg-zinc-900 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-800 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
            <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
            Export
        </button>
    </div>
</div>

{{-- Filter Bar --}}
<div class="flex flex-wrap items-center gap-3 mb-4">

    {{-- Search --}}
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <form action="{{ route('admin.products') }}" method="GET" class="flex items-center gap-3">
            <input id="search" name="search" type="text" value="{{ request('search') }}"
                placeholder="Search by name, categories, code, or barcode..."
                class="w-full pl-8 pr-8 py-1.5 text-xs bg-white dark:bg-zinc-900 text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
            @if (request('search'))
                <button type="button" onclick="document.getElementById('search').value=''; this.form.submit();"
                    class="absolute right-[90px] top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 z-10">
                    ✕
                </button>
            @endif
            <button type="submit"
                class="bg-p font-medium text-sm py-[5px] px-2 hover:bg-[#0F6E8C] text-white rounded-md">Submit</button>
        </form>
    </div>

    {{-- Category --}}
    <div class="relative">
        <select id="categoryFilter"
            class="bg-white dark:bg-zinc-900 bg-none appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] cursor-pointer">
            <option value="all">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Status --}}
    <div class="relative">
        <select id="statusFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] cursor-pointer">
            <option value="all">All Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Stock --}}
    <div class="relative">
        <select id="stockFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] cursor-pointer">
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
<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Product</th>
                    <th class="pb-2 px-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-right">Price</th>
                    <th class="pb-2 px-4 font-medium text-center">Stock</th>
                    <th class="pb-2 px-4 font-medium">Barcode</th>
                    <th class="pb-2 px-4 font-medium text-center">Status</th>
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
                        <td class="py-3 px-4 text-gray-600 dark:text-zinc-400">
                            {{ $product->category->name ?? 'Unassigned' }}
                        </td>
                        <td class="py-3 px-4 text-right font-medium text-gray-800 dark:text-zinc-200">
                            ${{ number_format($product->selling_price, 2) }}
                        </td>
                        <td class="py-3 px-3 text-center whitespace-nowrap">
                            @if ($product->stock_quantity <= 0)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">Out
                                    of stock</span>
                            @elseif($product->stock_quantity < $product->low_stock_threshold)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">{{ $product->stock_quantity }}
                                    Low</span>
                            @else
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 dark:bg-green-950/40 text-green-600 dark:text-green-400">{{ $product->stock_quantity }}</span>
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-gray-500 dark:text-zinc-500 text-xs">
                            {{ $product->barcode ?? '-' }}
                        </td>
                        <td class="py-3 text-center">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full
                                {{ $product->status === 'active' ? 'bg-green-50 dark:bg-green-950/40 text-green-600 dark:text-green-400' : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-zinc-500' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click="openEdit({{ json_encode($product) }})" type="button"
                                    class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C] dark:hover:text-[#0F6E8C]"
                                    title="Edit">
                                    <x-heroicon-m-pencil-square class="w-5 h-5" />
                                </button>
                                <button onclick="deleteProduct({{ $product->id }}, this)"
                                    class="text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300"
                                    title="Delete">
                                    <x-heroicon-m-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 dark:text-zinc-500 text-sm">
                            No products found
                        </td>
                    </tr>
                @endforelse

                {{-- Empty state for category filter --}}
                <tr id="noCategoryRow" style="display:none;">
                    <td colspan="7" class="text-center py-16">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-zinc-600 mb-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-zinc-400">No products found</h3>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Try selecting a different category
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
