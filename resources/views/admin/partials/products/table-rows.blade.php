@forelse($products as $product)
    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
        <td class="py-3 pr-4">
            <div class="flex items-center gap-3">
                <img src="{{ $product->image ?? 'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png' }}"
                    class="w-12 h-12 bg-p/10 dark:bg-p/20 rounded-xs shrink-0 object-cover" />
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
        <td class="py-3 px-4 text-xs whitespace-nowrap">
            <p class="text-gray-500 dark:text-zinc-500">Created
                <label
                    class="text-gray-600 dark:text-zinc-500 font-semibold">{{ $product->created_at->format('M d, Y') }}</label>
            </p>
            <p class="text-gray-500 dark:text-zinc-500">Updated
                <label
                    class="text-gray-600 dark:text-zinc-500 font-semibold">{{ $product->updated_at->format('H:i, M d') }}</label>
            </p>
        </td>
        <td class="py-3 pl-2">
            <div class="flex items-center justify-end gap-1">

                <button
                    @click="openEdit({
                                            id: {{ $product->id }},
                                            name: '{{ addslashes($product->name) }}',
                                            code: '{{ $product->code }}',
                                            barcode: '{{ $product->barcode }}',
                                            selling_price: {{ $product->selling_price }},
                                            stock_quantity: {{ $product->stock_quantity }},
                                            status: '{{ $product->status }}',
                                            image: '{{ $product->image }}',
                                            category_id: {{ $product->category_id }},
                                            category: {
                                                id: {{ $product->category->id }},
                                                code: '{{ $product->category->code }}',
                                                name: '{{ $product->category->name }}'
                                            }
                                        })"
                    type="button" class="text-gray-400 dark:text-zinc-500 hover:text-p dark:hover:text-p"
                    title="Edit">
                    <x-heroicon-m-pencil-square class="w-5 h-5" />
                </button>
                <button onclick="deleteProduct({{ $product->id }}, this)"
                    class="trash-btn text-red-500 hover:text-red-600" title="Delete">
                    <x-heroicon-m-trash class="w-5 h-5" />
                </button>

            </div>

        </td>


        <td class="pl-4">
            {{-- Checkbox - shown only in bulk mode --}}
            <input type="checkbox" class="bulk-checkbox rounded border-gray-300 cursor-pointer"
                data-id="{{ $product->id }}" onchange="updateBulkBar()">
        </td>
    </tr>
@empty

    {{-- Empty state for category filter --}}
    <tr>
        <td colspan="6" class="text-center py-5">
            <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
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
@endforelse
