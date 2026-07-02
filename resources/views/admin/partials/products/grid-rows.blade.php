<div id="productsGridBody" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 2xl:grid-cols-6 gap-4">
    @forelse($products as $product)
        <div data-product-card data-category="{{ $product->category->name ?? '' }}"
            data-status="{{ ucfirst($product->status) }}" data-stock="{{ $product->stock_quantity }}"
            data-threshold="{{ $product->low_stock_threshold }}"
            class="rounded-sm bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 flex flex-col shadow-xs hover:shadow-md transition">
            {{-- Image with overlays --}}
            <div class="relative w-full overflow-hidden rounded-t-sm" style="height:200px;">
                <img src="{{ $product->image ?? 'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png' }}"
                    style="width:100%; height:100%; object-fit:cover; object-position:center;" />

                {{-- Code top right --}}
                <span
                    class="absolute top-1.5 right-1.5 bg-black/70 text-white text-[10px] px-1.5 py-0.5 rounded font-mono">
                    {{ $product->code }}
                </span>
            </div>
            {{-- Content --}}
            <div class="p-2 flex flex-col gap-0.5 flex-1 bg-gray-200/40 dark:bg-zinc-800/30">

                {{-- Name --}}
                <p class="text-xs font-semibold text-gray-800 dark:text-zinc-100 line-clamp-2 leading-tight">
                    {{ $product->name }}</p>

                {{-- Category --}}
                <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $product->category->name ?? 'Unassigned' }}
                </p>

                {{-- Price --}}
                <p class="text-sm font-bold text-[#0F6E8C] mt-1">${{ number_format($product->selling_price, 2) }}</p>

                {{-- Date --}}
                <p class="text-[10px] text-gray-400 dark:text-zinc-500">
                    Created: <label
                        class="text-gray-500 dark:text-zinc-400">{{ $product->created_at->format('H:mm, M d, Y') }}</label>
                </p>

                <div
                    class="flex justify-between items-center mt-auto border-t pt-2 border-gray-100 dark:border-zinc-800">
                    {{-- Stock bottom right --}}
                    <span
                        class=" text-[11px] font-semibold px-1.5 py-0.5 rounded
    {{ $product->stock_quantity <= 0 ? 'bg-red-500 text-white' : ($product->stock_quantity < $product->low_stock_threshold ? 'bg-amber-400 text-white' : 'bg-green-500 dark:bg-green-600 text-white') }}">
                        {{ $product->stock_quantity <= 0 ? 'Out of stock' : ($product->stock_quantity < $product->low_stock_threshold ? $product->stock_quantity . ' Low stock' : $product->stock_quantity . ' In stock') }}
                    </span>
                    {{-- Actions --}}
                    <div class="flex justify-end items-center gap-1 mt-auto">
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
                            class="text-gray-400 hover:text-[#0F6E8C] transition">
                            <x-heroicon-m-pencil-square class="w-[19px] h-[19px]" />
                        </button>
                        <button onclick="deleteProduct({{ $product->id }}, this)"
                            class="text-red-400 hover:text-red-600 transition" title="Delete">
                            <x-heroicon-m-trash class="w-[19px] h-[19px]" />
                        </button>

                        <input type="checkbox" class="bulk-checkbox rounded border-gray-300 cursor-pointer"
                            data-id="{{ $product->id }}" onchange="updateBulkBar()">

                    </div>
                </div>
            </div>
        </div>

    @empty
        {{-- Server-side empty --}}
        <div class="col-span-full flex flex-col items-center justify-center py-16">
            <div class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-1">No products found</h3>
            <p class="text-xs text-gray-400 dark:text-zinc-500">Get started by adding your first product.</p>
            <button @click="openAdd()"
                class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Your First Product
            </button>
        </div>
    @endforelse
</div>

{{-- Filter empty state - OUTSIDE the grid --}}
<div id="noFilterResultsGrid" style="display:none;" class="flex flex-col items-center justify-center py-16">
    <div class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
        <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
