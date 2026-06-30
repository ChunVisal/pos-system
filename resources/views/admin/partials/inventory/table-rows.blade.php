<table id="InventoryTable" class="w-full text-sm">
    <thead>
        @forelse($products as $product)
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
                        <img src="{{ $product->image ?? 'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png' }}"
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
        @endforelse
        {{-- Empty state for category filter --}}
        <tr id="noCategoryRow" style="display:none;">
            <td class="text-center py-5">
                <div class="col-span-full flex flex-col items-center justify-center py-16">
                    <div
                        class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-1">No products
                        found</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-500">Get started by adding your first
                        product.</p>
                    <button @click="openAdd()"
                        class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                        <i class="fa-solid fa-plus text-[10px]"></i> Add Your First Product
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
